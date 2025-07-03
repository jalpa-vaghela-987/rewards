<?php

namespace App\Jobs;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPerkSweetConnectInvite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $meeting;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $meeting = $this->meeting;

        $user1 = $this->meeting->user1;
        $user2 = $this->meeting->user2;
        $user1_email = $this->meeting->user1->email;
        $user2_email = $this->meeting->user2->email;

        $start = Carbon::parse($this->meeting->start);
        $end = Carbon::parse($this->meeting->start)->addMinutes(30);
        $startTime = $start->format('m/d/Y H:i:s');
        $endTime = $end->format('m/d/Y H:i:s');
        $subject = $user1->name.' <> '.$user2->name.' — '.appName().' Connect';
        $location = $this->meeting->zoom_link ?? 'To be decided by participants';
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
LOCATION: Zoom Meeting
PRIORITY:5
SEQUENCE:0
SUMMARY;LANGUAGE=en-us:'.$subject.'
TRANSP:OPAQUE
UID:'.$now->format("Ymd\THis\Z").'-'.$meeting->id.'
X-ALT-DESC;FMTTYPE=text/html:'.appName().' Connect is inviting you to a scheduled Zoom meeting.
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
X-MICROSOFT-CDO-IMPORTANCE:1
ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN='.$user1->name.':MAILTO:'.$user1_email.'
ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;RSVP=TRUE;CN='.$user2->name.':MAILTO:'.$user2_email.'
ORGANIZER;CN='.appName().' Connect:mailto:info@perksweet.com
END:VEVENT
END:VCALENDAR
';
        Mail::send('emails.zoom-invite2', ['meeting'=>$this->meeting], function ($m) use ($meeting, $subject, $ical, $user1, $user2, $user1_email, $user2_email) {
            $m->from('info@perksweet.com', appName().' Connect');
            $m->to([$user1_email, $user2_email], [$user1->name, $user2->name])->subject($subject);
            $m->attachData($ical, 'invite.ics', [
                    'mime' => 'text/calendar;charset=UTF-8;method=REQUEST',
                ]);
        });
        sleep(2);
    }
}
