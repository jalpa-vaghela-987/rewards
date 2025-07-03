<?php

namespace App\Console;

use App\Console\Commands\AddTangoCurrencyData;
use App\Console\Commands\ExpireKudosToGive;
use App\Console\Commands\KudosToGiveAboutToExpire;
use App\Console\Commands\PerkSweetConnectMatch;
use App\Console\Commands\RefillKudosToGive;
use App\Console\Commands\SendBirthdayGift;
use App\Console\Commands\SendKudosReport;
use App\Console\Commands\SendMailFromScheduler;
use App\Console\Commands\SendWorkAnniversaryGift;
use App\Console\Commands\UpcomingSpecialDayReminderReport;
use App\Console\Commands\UpdateExchangeRatesTable;
use App\Console\Commands\UpdateTangoCards;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;

class Kernel extends ConsoleKernel
{
    public $timezone = 'America/New_York';

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendMailFromScheduler::class,
        SendWorkAnniversaryGift::class,
        SendBirthdayGift::class,
        PerkSweetConnectMatch::class,
        ExpireKudosToGive::class,
        KudosToGiveAboutToExpire::class,
        RefillKudosToGive::class,
        SendKudosReport::class,
        UpdateExchangeRatesTable::class,
        UpdateTangoCards::class,
        AddTangoCurrencyData::class,
        UpcomingSpecialDayReminderReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    { // NOTE: When adding a command, make sure you include it in the above array! and use at the top!!
//        $schedule->command('send:birthday-gift')->dailyAt('6:30')->timezone($this->timezone);
//        $schedule->command('send:work-anniversary-gift')->dailyAt('6:10')->timezone($this->timezone);

        $schedule->command('backup:run')->daily()->at('01:00');
        $schedule->command('connect:match')->dailyAt('14:00')->timezone($this->timezone);
        $schedule->command('expire:kudo_to_give')->dailyAt('1:30')->timezone($this->timezone);
        $schedule->command('expire:kudos_to_give_expire_in_1_week')->mondays()->at('13:00')->timezone($this->timezone);
        $schedule->command('expire:kudos_to_give_expire_in_1_week')->thursdays()->at('13:00')->timezone($this->timezone);
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping()->timezone($this->timezone);
        $schedule->command('refill:kudos_to_give')->monthly()->timezone($this->timezone);
        $schedule->command('send:test-mail')->dailyAt('10:05')->timezone($this->timezone);
        $schedule->command('send:kudos_report')->wednesdays()->at('15:00')->timezone($this->timezone);
        $schedule->command('exchange-rates:update')->hourly()->withoutOverlapping()->timezone($this->timezone);
        $schedule->command('tango:update')->hourly()->withoutOverlapping()->timezone($this->timezone);

        $schedule->command('notify:users-to-contribute-in-group-card')->dailyAt('13:00')->timezone($this->timezone);

        $schedule->command('friendly-reminder:send-kudos')->daily()->timezone($this->timezone);

        $schedule->command('remind:upcoming-special-days-report')
            ->mondays()
            ->at('15:00')
            ->timezone($this->timezone)
            ->when(function () {
                $firstMonday = Carbon::now($this->timezone)->parse('first monday of today')->format('Y-m-d');
                $thirdMonday = Carbon::now($this->timezone)->parse('third monday of today')->format('Y-m-d');

                return in_array(Carbon::now($this->timezone)->format('Y-m-d'), [$firstMonday, $thirdMonday]);
            });

        if (Schema::hasTable('users')) {
            $timezones = User::distinct()
                ->whereNotNull('timezone')
                ->pluck('timezone')
                ->toArray();

            foreach ($timezones as $timezone) {
                $birthday_run_at = now($timezone)->startOfDay()->addHours(6)->addMinutes(30)->utc()->format('H:i');
                $anniversary_run_at = now($timezone)->startOfDay()->addHours(6)->addMinutes(10)->utc()->format('H:i');

                $schedule->command("send:birthday-gift $timezone")->dailyAt($birthday_run_at);
                $schedule->command("send:work-anniversary-gift $timezone")->dailyAt($anniversary_run_at);
            }

            foreach ($timezones as $timezone) {
                $birthday_run_at = now($timezone)->startOfDay()->addHours(6)->addMinutes(30)->utc()->format('H:i');
                $anniversary_run_at = now($timezone)->startOfDay()->addHours(6)->addMinutes(10)->utc()->format('H:i');

                $schedule->command("send:birthday-reminder $timezone")->dailyAt($birthday_run_at);
                $schedule->command("send:work-anniversary-reminder $timezone")->dailyAt($anniversary_run_at);
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
