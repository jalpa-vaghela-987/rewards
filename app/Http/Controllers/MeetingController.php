<?php

namespace App\Http\Controllers;

use App\Jobs\SendPerkSweetConnectInvite;
use App\Models\Company;
use App\Models\Meeting;
use App\Models\MeetingConfig;
use App\Models\User;
use App\Traits\ZoomJWT;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MeetingController extends Controller
{
    use ZoomJWT;

    const MEETING_TYPE_INSTANT = 1;
    const MEETING_TYPE_SCHEDULE = 2;
    const MEETING_TYPE_RECURRING = 3;
    const MEETING_TYPE_FIXED_RECURRING_FIXED = 8;
    //
    public $best_times = [
        '14:30',
        '11:00',
        '15:30',
        '10:00',
        '15:00',
        '10:30',
        '14:00',
        '13:30',
        '13:00',
        '11:30',
        '14:30', // yes, this is twice :)
    ];

    public $allTimes = [];

    public $best_days = [
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Tuesday', // listed twice
        'Wednesday',
        'Thursday',
        'Tuesday',
        'Friday', // only listed once
    ];

    public function __construct()
    {
        $this->best_times = collect($this->best_times);
        $this->best_days = collect($this->best_days);

        $this->allTimes = collect($this->allTimes);
        for ($i = 0; $i < 48; $i++) {
            if ($i % 2 == 1) {
                $m = ':30';
            } else {
                $m = ':00';
            }
            $h = floor($i / 2);
            $h = sprintf('%02d', $h);
            $this->allTimes->push($h.$m);
        }
    }

    public function register()
    {
        return view('meetings.register');
    }

    public function connect()
    {
        return view('meetings.connect');
    }

    public function create(Request $request)
    {
        $request->validate([
            'interests'  => ['nullable', 'max:350'],
            'expertise'  => ['nullable', 'max:350'],
            'develop'    => ['nullable', 'max:350'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i'],
            'active'     => ['nullable', 'integer', 'min:0', 'max:1'],
        ]);

        if (Auth::user()->meetingConfig && Auth::user()->meetingConfig->id) {
            $m = Auth::user()->meetingConfig;
        } else {
            $m = new MeetingConfig;
            $m->user()->associate(Auth::user());
        }

        $m->interests = $request->interests;
        $m->expertise = $request->expertise;
        $m->develop = $request->develop;
        $m->start_time = $request->start_time;
        $m->end_time = $request->end_time;
        $m->active = $request->active ?? 0;
        $m->save();

        return redirect()->route('connect');
        //return view('meetings.store');
    }

    public function view(Meeting $meeting)
    {
        return $meeting;
    }

    public function create_zoom(Meeting $meeting)
    {
        $topic = $meeting->user1->name.' <> '.$meeting->user2->name;
        $agenda = '';

        $path = 'users/me/meetings';
        $response = $this->zoomPost($path, [
            'topic'      => $topic,
            'type'       => self::MEETING_TYPE_SCHEDULE,
            'start_time' => $this->toZoomTimeFormat($meeting->start),
            'duration'   => (int) $meeting->minutes,
            'agenda'     => $agenda,
            'settings'   => [
                'host_video'        => false,
                'participant_video' => false,
                'waiting_room'      => true,
            ],
        ]);

        return [
            'success' => $response->status() === 201,
            'data'    => json_decode($response->body(), true),
        ];
    }

    /////////////////////////////////////////////
    ////////////////////////////////////////////
    ///////// For the matchmaking process //////
    ////////////////////////////////////////////

    public function match(Company $company)
    {
        //note this is now run by a command connect:match

        //return $this->enroll_all_users();
        //return $this->allTimes;
        //return $this->find_best_time(Auth::user(),User::find(2)->first());
        // return count(Auth::user()->prevMeetings()->pluck("name")->unique());
        if (! $company->using_connect) {
            return;
        }

        if (! $company) {
            $company = Company::find(Auth::user()->company->id);
        }

        $users = MeetingConfig::all()->where('active', 1)->pluck('user')->unique()->where('company_id', $company->id)->flatten()->shuffle();

        $new_meetings = round(count($users) / 20, 0);
        if ($new_meetings < 1 && count($users) > 1 && rand(1, 10) < count($users)) {
            $new_meetings = 1;
        }
        //$new_meetings = 10;
        $loop_users = $users;

        for ($i = 0; $i < $new_meetings; $i++) {
            $matched = $this->find_next_match($loop_users);
            if ($matched) {
                $u1 = $matched[0];
                $u2 = $matched[1];
                $this->new_meeting($u1, $u2);
                $loop_users = $loop_users->where('id', '!=', $u1->id)->where('id', '!=', $u2->id);
            }
        }
    }

    public function find_next_match($users)
    {
        foreach ($users as $u1) {
            foreach ($users as $u2) {
                if ($u1->id != $u2->id) {
                    if (Carbon::parse($u1->start_time) < Carbon::parse($u2->end_time)
                        && Carbon::parse($u2->start_time) < Carbon::parse($u1->end_time)) {
                        if (! $u1->hasMetWith($u2)) {
                            return [$u1, $u2];
                        }
                    }
                }
            }
        }
    }

    public function new_meeting(User $u1, User $u2)
    {
        $time = $this->find_best_time($u1, $u2);
        if (! $time) {
            return;
        }
        $m = new Meeting;
        $m->create($u1, $u2);
        $m->start = $time;
        $m->save();
        // $r = $this->create_zoom($m);
        // if ($r['success']) {
        //     $m->zoom_id = $r['data']['id'];
        //     $m->zoom_link = $r['data']['start_url'];
        //     $m->zoom_uuid = $r['data']['uuid'];
        //     $m->zoom_pw = $r['data']['h323_password'];
        //     $m->save();
        // }
        echo 'new meeting created between '.$u1->name.' and '.$u2->name.' on '.$m->start->format('l, F dS, Y H:is').'<br>';
        //echo $m->user1;
        //echo $m->start->format("m/d/Y H:i:s");
        //Mail::to('nmlynch15@outlook.com')->send(new MeetingInviteMail($m));
        $job = (new SendPerkSweetConnectInvite($m));
        dispatch($job);
        //$this->send_zoom_invite($m);
    }

    public function find_best_time(User $u1, User $u2)
    {
        //thesis is as follows:
        // Always avoid Mondays
        // Friday afternoons are likely to get rescheduled
        // Tuesday at 2:30pm is the "time people are most free" - according to article I found
        // Meetings need to be in intervals of 30 minutes
        // Avoid 12-1pm for "lunch"
        // no weekends

        //Algo walk through
        // first shuffle $best_times
        // go through each time to check if in the window works
        // if so choose a day at random from $best_days (I havent made certain days allowed to be unavailable yet)
        // if none of these times work create/reference an array of all 30 minute intervals
        // shuffle the array
        // go through those times in the same process

        $mc1 = $u1->meetingConfig;
        $mc2 = $u2->meetingConfig;

        $u1_start = Carbon::parse($mc1->start_time);
        $u1_end = Carbon::parse($mc1->end_time);
        $u2_start = Carbon::parse($mc2->start_time);
        $u2_end = Carbon::parse($mc2->end_time);
        // first checks the best dates

        $chosen = false;
        foreach ($this->best_times->shuffle() as $t) {
            $ct = Carbon::parse($t);
            if ($ct > $u1_start && $ct > $u2_start) {
                if ($ct < $u1_end && $ct < $u2_end) {
                    $chosen = $ct;
                }
            }
        }
        // then checks the bulk ones
        foreach ($this->allTimes->shuffle() as $t) {
            $ct = Carbon::parse($t);
            if ($ct > $u1_start && $ct > $u2_start) {
                if ($ct < $u1_end && $ct < $u2_end) {
                    $chosen = $ct;
                }
            }
        }
        //return $chosen->timestamp;

        // now choose a date
        $day = $this->best_days->random(1)->first();

        $finaldate = false;
        if ($chosen) {
            //echo $day;
            //echo $chosen->format("H:is");
            //echo "\n";
            $finaldate = Carbon::now()->next($day)->addWeeks(3)->setTimeFrom($chosen);
        }

        return $finaldate;
    }

    public function enroll_all_users()
    {
        //this is now a command...
        foreach (User::all()->where('company_id', Auth::user()->company->id) as $u) {
            $r1 = rand(5, 22);
            $m = new MeetingConfig;
            $m->user()->associate($u);
            $m->interests = 'hoops';
            $m->expertise = 'code';
            $m->develop = 'leadership';
            $m->start_time = (string) $r1.':'.rand(0, 59);
            $m->end_time = (string) min($r1 + rand(0, 22 - 5), 23).':'.rand(0, 59);
            $m->save();
        }
    }

    public function send_zoom_invite(Meeting $meeting)
    {
        // Do not user

        /// NOTE: THIS FUNCTION HAS BEEN MOVED WITHIN the job SendPerkSweetConnectInvite
        $user1 = $meeting->user1;
        $user2 = $meeting->user2;
        $user1_email = 'nmlynch15@outlook.com';
        $user2_email = 'nicholas.lynch15@gmail.com';

        $start = Carbon::parse($meeting->start);
        $end = Carbon::parse($meeting->start)->addMinutes(30);
        $startTime = $start->format('m/d/Y H:i:s');
        $endTime = $end->format('m/d/Y H:i:s');
        $subject = $user1->name.' <> '.$user2->name.' — '.appName().' Connect';
        $location = $meeting->zoom_link ?? 'To be decided by participants';
        $domain = 'PerkSweet.com';
        $now = now();

        $ical = 'BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 16.0 MIMEDIR//EN
VERSION:2.0
METHOD:REQUEST
X-MS-OLK-FORCEINSPECTOROPEN:TRUE
BEGIN:VTIMEZONE
TZID:America/New_York
BEGIN:STANDARD
DTSTART:16011104T020000
RRULE:FREQ=YEARLY;BYDAY=1SU;BYMONTH=11
TZOFFSETFROM:-0400
TZOFFSETTO:-0500
END:STANDARD
BEGIN:DAYLIGHT
DTSTART:16010311T020000
RRULE:FREQ=YEARLY;BYDAY=2SU;BYMONTH=3
TZOFFSETFROM:-0500
TZOFFSETTO:-0400
END:DAYLIGHT
END:VTIMEZONE
BEGIN:VEVENT
CLASS:PUBLIC
CREATED:'.$now->format("Ymd\THis\Z").'
DESCRIPTION:'.appName().' Connect is inviting you to a scheduled meeting.
DTEND;TZID=America/New_York:'.$end->format("Ymd\THis").'
DTSTAMP:'.$now->format("Ymd\THis\Z").'
DTSTART;TZID=America/New_York:'.$start->format("Ymd\THis").'
LAST-MODIFIED:'.$now->format("Ymd\THis\Z").'
LOCATION: To be determined with other party.
PRIORITY:5
SEQUENCE:0
SUMMARY;LANGUAGE=en-us:'.$subject.'
TRANSP:OPAQUE
UID:'.$now->format("Ymd\THis\Z").'-'.$meeting->id.'
X-ALT-DESC;FMTTYPE=text/html:'.appName().' Connect is inviting you to a scheduled meeting.
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
X-MICROSOFT-CDO-IMPORTANCE:1
ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN='.$user1->name.':MAILTO:'.$user1_email.'
ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN='.$user2->name.':MAILTO:'.$user2_email.'
ORGANIZER;CN='.appName().' Connect:mailto:info@perksweet.com
END:VEVENT
END:VCALENDAR
';
        Mail::send('emails.zoom-invite2', ['meeting' => $meeting], function ($m) use ($meeting, $subject, $ical, $user1, $user2, $user1_email, $user2_email) {
            $m->from('info@perksweet.com', appName().' Connect');
            $m->to([$user1_email, $user2_email], [$user1->name, $user2->name])->subject($subject);
            $m->attachData($ical, 'invite.ics', [
                'mime' => 'text/calendar;charset=UTF-8;method=REQUEST',
            ]);
        });
    }

    // end send zoom func
    //////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////
}
