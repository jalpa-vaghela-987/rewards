<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingSpecialDayReport extends Notification implements ShouldQueue
{
    use Queueable;

    public $users;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (! app()->environment('production')) {
            $this->delay(now()->addSeconds(2));
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->hasUpcomingSpecialDays($notifiable) && $notifiable->emails_opt_in
            ? ['mail']
            : [];
    }

    public function hasUpcomingSpecialDays($user)
    {
        $from = now();
        $to = now()->addDays(30);

        return $this->birthdayQuery($user, $from, $to)
            ->union($this->anniversaryQuery($user, $from, $to))
            ->exists();
    }

    public function birthdayQuery($user, $from, $to)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $to->format('m-d');

        $query = User::query()
            ->where('company_id', $user->company_id)
            ->whereNotNull('birthday');

        if ($fromMonthDay <= $tillMonthDay) {
            $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(birthday, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }

        return $query->selectRaw(
            "id, name, email, position, birthday as special_day_at, 'birthday' as special_day,
            (birthday + INTERVAL (YEAR(CURRENT_DATE) - YEAR(birthday)) YEAR) as current_special_day,
            (birthday + INTERVAL (YEAR(CURRENT_DATE) - YEAR(birthday)) + 1 YEAR) as next_special_day"
        );
    }

    public function anniversaryQuery($user, $from, $to)
    {
        $fromMonthDay = $from->format('m-d');
        $tillMonthDay = $to->format('m-d');

        $query = User::query()
            ->where('company_id', $user->company_id)
            ->whereNotNull('anniversary');

        if ($fromMonthDay <= $tillMonthDay) {
            $query->whereRaw("DATE_FORMAT(anniversary, '%m-%d') BETWEEN '{$fromMonthDay}' AND '{$tillMonthDay}'");
        } else {
            $query->where(function ($query) use ($fromMonthDay, $tillMonthDay) {
                $query->whereRaw("DATE_FORMAT(anniversary, '%m-%d') BETWEEN '{$fromMonthDay}' AND '12-31'")
                    ->orWhereRaw("DATE_FORMAT(anniversary, '%m-%d') BETWEEN '01-01' AND '{$tillMonthDay}'");
            });
        }

        return $query->selectRaw(
            "id, name, email, position, anniversary as special_day_at, 'anniversary' as special_day,
            (anniversary + INTERVAL (YEAR(CURRENT_DATE) - YEAR(anniversary)) YEAR) as current_special_day,
            (anniversary + INTERVAL (YEAR(CURRENT_DATE) - YEAR(anniversary)) + 1 YEAR) as next_special_day"
        );
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = appName(false, $notifiable);
        $appLogo = appLogo(false, $notifiable);

        $from = now();
        $to = now()->addDays(30);

        $users = $this->birthdayQuery($notifiable, $from, $to)
            ->union($this->anniversaryQuery($notifiable, $from, $to))
            ->orderByRaw('case when current_special_day >= CURRENT_DATE THEN current_special_day ELSE next_special_day END')
            ->get();

        return (new MailMessage)
            ->subject("$appName Reminder - Upcoming Birthdays and Work Anniversaries")
            ->markdown('mails.upcoming-special-days-email-report', [
                'appName'     => $appName,
                'appLogo'     => $appLogo,
                'specialDays' => $users,
                'buttonUrl'   => route('people'),
                'buttonText'  => 'Visit People Page',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
