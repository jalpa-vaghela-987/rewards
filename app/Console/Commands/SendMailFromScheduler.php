<?php

namespace App\Console\Commands;

use App\Mail\SchedulerWorkingMail;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMailFromScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:test-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //info('cron working');

//       $nl = User::where('email','=','nick@perksweet.com')->first();
//       $nl->notify(new TestNotification);
//
        Mail::to('nick@perksweet.com')->send(new SchedulerWorkingMail());
    }
}
