<?php

namespace App\Mail;

use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingInviteMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $user1;
    public $user2;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
        $this->user1 = $meeting->user1;
        $this->user2 = $meeting->user2;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $start = Carbon::parse($this->meeting->start);
        $end = Carbon::parse($this->meeting->start)->addMinutes(30);

        $from_name = appName().' Connect';
        $from_address = 'info@perksweet.com';
        // $to_name = "Receiver Name";
        // $to_address = "nick@perksweet.com";// change this in future
        // $startTime = "05/15/2021 12:00:00";
        // $endTime = "05/15/2021 12:30:00";
        $startTime = $start->format('m/d/Y H:i:s');
        $endTime = $end->format('m/d/Y H:i:s');
        $subject = $this->user1->name.' <> '.$this->user2->name.' —'.appName().' Connect';
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
DESCRIPTION:'.appName().' Connect is inviting you to a scheduled Zoom meeting.
DTEND;TZID=America/New_York:'.$end->format("Ymd\THis").'
DTSTAMP:'.$now->format("Ymd\THis\Z").'
DTSTART;TZID=America/New_York:'.$start->format("Ymd\THis").'
LAST-MODIFIED:'.$now->format("Ymd\THis\Z").'
LOCATION:'.$location.'
PRIORITY:5
SEQUENCE:0
SUMMARY;LANGUAGE=en-us:'.$subject.'
TRANSP:OPAQUE
UID:'.$now->format("Ymd\THis\Z").'-'.$this->meeting->id.'
X-ALT-DESC;FMTTYPE=text/html:'.appName().' Connect is inviting you to a scheduled Zoom meeting.
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
X-MICROSOFT-CDO-IMPORTANCE:1
END:VEVENT
END:VCALENDAR
';

        return $this->from('info@perksweet.com')
               ->view('emails.zoom-invite2')
                ->attachData($ical, 'invite.ics', [
                    'mime' => 'text/calendar;charset=UTF-8;method=REQUEST',
                ]);
    }

    public function build_works()
    {
        $start = Carbon::parse($this->meeting->start);
        $end = Carbon::parse($this->meeting->start)->addMinutes(30);

        $from_name = appName().' Connect';
        $from_address = 'info@perksweet.com';
        $to_name = 'Receiver Name';
        $to_address = 'nick@perksweet.com'; // change this in future
        // $startTime = "05/15/2021 12:00:00";
        // $endTime = "05/15/2021 12:30:00";
        $startTime = $start->format('m/d/Y H:i:s');
        $endTime = $end->format('m/d/Y H:i:s');
        $subject = $this->user1->name.' <> '.$this->user2->name.' -'.appName().' Connect';
        $location = 'Zoom Dial-in TBD';
        $domain = 'perksweet.com';

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
CREATED:20210504T000631Z
DESCRIPTION:'.appName().' Connect is inviting you to a scheduled Zoom meeting.
DTEND;TZID=America/New_York:20210503T210000
DTSTAMP:20210504T000611Z
DTSTART;TZID=America/New_York:20210503T200000
LAST-MODIFIED:20210504T000631Z
LOCATION:TBD
PRIORITY:5
SEQUENCE:0
SUMMARY;LANGUAGE=en-us:My Meeting
TRANSP:OPAQUE
UID:20210504T000611Z-95378197685@fe80:0:0:0:1080:3fff:fe1c:150dens5
X-ALT-DESC;FMTTYPE=text/html:XXX
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
X-MICROSOFT-CDO-IMPORTANCE:1
END:VEVENT
END:VCALENDAR
';

        return $this->from('info@perksweet.com')
               ->markdown('emails.meeting-invite')
                ->attachData($ical, 'invite.ics', [
                    'mime' => 'text/calendar;charset=UTF-8;method=REQUEST',
                ]);
    }
}
