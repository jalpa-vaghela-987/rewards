	<?php 
// NOT USED!!!!
	$from_name = "Your Name"; 
	$from_address = "youremail@yourdomain.com";
	$to_name = "Receiver Name";
	$to_address = "receiveremail@yourdomain.com";
	$startTime = "04/15/2020 12:00:00";
	$endTime = "04/15/2020 12:30:00";
	$subject = "Reminder for event";
	$description = "eminder for event";
	$location = "Your Location";
	$domain = 'yourdomain.com'; 

	//Create Email Headers 
	$mime_boundary = "----Meeting Booking----".MD5(TIME()); 
	$headers = "From: ".$from_name." <".$from_address.">\n"; 
	$headers .= "Reply-To: ".$from_name." <".$from_address.">\n"; 
	$headers .= "MIME-Version: 1.0\n"; 
	$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n"; 
	$headers .= "Content-class: urn:content-classes:calendarmessage\n"; 

	//Create Email Body (HTML) 
	$message = "--$mime_boundary\r\n"; 
	$message .= "Content-Type: text/html; charset=UTF-8\n"; $message .= "Content-Transfer-Encoding: 8bit\n\n"; 
	$message .= "<html>\n"; 
	$message .= "<body>\n"; 
	$message .= 'Demo Message'; 
	$message .= "</body>\n"; 
	$message .= "</html>\n"; 
	$message .= "--$mime_boundary\r\n"; 

	//Event setting 
	$ical = 'BEGIN:VCALENDAR' . "\r\n" . 'PRODID:-//Microsoft Corporation//Outlook 10.0 MIMEDIR//EN' . "\r\n" . 'VERSION:2.0' . "\r\n" . 'METHOD:REQUEST' . "\r\n" . 'BEGIN:VTIMEZONE' . "\r\n" . 'TZID:Eastern Time' . "\r\n" . 'BEGIN:STANDARD' . "\r\n" . 'DTSTART:20091101T020000' . "\r\n" . 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=1SU;BYMONTH=11' . "\r\n" . 'TZOFFSETFROM:-0400' . "\r\n" . 'TZOFFSETTO:-0500' . "\r\n" . 'TZNAME:EST' . "\r\n" . 'END:STANDARD' . "\r\n" . 'BEGIN:DAYLIGHT' . "\r\n" . 'DTSTART:20090301T020000' . "\r\n" . 'RRULE:FREQ=YEARLY;INTERVAL=1;BYDAY=2SU;BYMONTH=3' . "\r\n" . 'TZOFFSETFROM:-0500' . "\r\n" . 'TZOFFSETTO:-0400' . "\r\n" . 'TZNAME:EDST' . "\r\n" . 'END:DAYLIGHT' . "\r\n" . 'END:VTIMEZONE' . "\r\n" . 'BEGIN:VEVENT' . "\r\n" . 'ORGANIZER;CN="'.$from_name.'":MAILTO:'.$from_address. "\r\n" . 'ATTENDEE;CN="'.$to_name.'";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:'.$to_address. "\r\n" . 'LAST-MODIFIED:' . date("Ymd\TGis") . "\r\n" . 'UID:'.date("Ymd\TGis", strtotime($startTime)).rand()."@".$domain."\r\n" . 'DTSTAMP:'.date("Ymd\TGis"). "\r\n" . 'DTSTART;TZID="Pacific Daylight":'.date("Ymd\THis", strtotime($startTime)). "\r\n" . 'DTEND;TZID="Pacific Daylight":'.date("Ymd\THis", strtotime($endTime)). "\r\n" . 'TRANSP:OPAQUE'. "\r\n" . 'SEQUENCE:1'. "\r\n" . 'SUMMARY:' . $subject . "\r\n" . 'LOCATION:' . $location . "\r\n" . 'CLASS:PUBLIC'. "\r\n" . 'PRIORITY:5'. "\r\n" . 'BEGIN:VALARM' . "\r\n" . 'TRIGGER:-PT15M' . "\r\n" . 'ACTION:DISPLAY' . "\r\n" . 'DESCRIPTION:Reminder' . "\r\n" . 'END:VALARM' . "\r\n" . 'END:VEVENT'. "\r\n" . 'END:VCALENDAR'. "\r\n"; 
	$message .= 'Content-Type: text/calendar;name="meeting.ics";method=REQUEST'."\n"; 
	$message .= "Content-Transfer-Encoding: 8bit\n\n"; 
	$message .= $ical; 


	//mail($to_address, $subject, $message, $headers); 



	/////////////// old ///////////////


// Route::get('ics', function(){

// 	// 1. Create Event domain entity
// 	$start = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2021-04-28 23:00:00'), false);
// 	$end = new DateTime(DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2021-04-28 24:00:00'), false);
// 	$occurrence = new TimeSpan($start, $end);
// 	$event = new Event();
// 	$event->setSummary('Lunch Meeting');
// 	$event->setDescription('Lorem Ipsum...');
// 	$event->setOccurrence($occurrence);


// 	// 2. Create Calendar domain entity
// 	$calendar = new Calendar([$event]);

// 	// 3. Transform domain entity into an iCalendar component
// 	$componentFactory = new CalendarFactory();
// 	$calendarComponent = $componentFactory->createCalendar($calendar);

// 	// 4. Set HTTP headers
// 	header('Content-Type: text/calendar; charset=utf-8');
// 	header('Content-Disposition: attachment; filename="cal11.ics"');

// 	// 5. Output
// 	echo $calendarComponent;


// });

// Route::get('cal', function(){
// 	$properities = [
//             'uid' => uniqid(),
//             'sequence' => 0,
//             'description' => 'Event Invitation via email.',
//             'dtstart' => date('2021-05-01 09:00'),
//             'dtend' => date('2021-05-01 10:00'),
//             'summary' => 'This is an event invitation sent through email.',
//             'location' => 'VR Punjab, S.A.S Nagar, Chandigarh',
//             'url' => 'www.example.com',
//         ];

// 	$ics_file = new ICS($properities);
// 	return $ics_file->toString();
// }

// Route::get('testmail', function () {

// 	// $link = Link::create(
//  //            'Birthday',
//  //            DateTime::createFromFormat('Y-m-d H:i', '2021-05-01 09:00'),
//  //            DateTime::createFromFormat('Y-m-d H:i', '2021-05-01 10:00')
//  //        )->ics();

// 	// $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

// 	// Storage::disk('local')->put('file.ics', (string)$link);
// 	// return response()->download($storagePath."/"."file.ics");
// 	//echo ($file);

//       //Mail::to('info@perksweet.com')->send(new TestAmazonSes('This is a test email'));
// });

// 	use Eluceo\iCal\Domain\ValueObject\TimeSpan;
// use Eluceo\iCal\Domain\ValueObject\DateTime;
// use Eluceo\iCal\Presentation\Factory\CalendarFactory;

// 	use Spatie\CalendarLinks\Link;

// use Eluceo\iCal\Domain\Entity\Calendar;
// use Eluceo\iCal\Domain\Entity\Event;

// use INSAN\ICS;



	?>