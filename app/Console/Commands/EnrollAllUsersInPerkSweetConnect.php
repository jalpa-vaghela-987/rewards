<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\MeetingConfig;
use Illuminate\Console\Command;

class EnrollAllUsersInPerkSweetConnect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connect:enroll_all_users {company=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enrolls everyone at the company in PerkSweet Connect';

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
        $company_id = $this->argument('company');
        $c = Company::find((int) $company_id);
        if (! $c) {
            return;
        }
        foreach ($c->users->where('active', 1) as $u) {
            if (! $u->MeetingConfig) {
                $m = new MeetingConfig;
                $m->user()->associate($u);
                $m->interests = '';
                $m->expertise = '';
                $m->develop = '';
                $m->start_time = '9:00';
                $m->end_time = '17:00';
                $m->save();
            } else {
                $u->MeetingConfig->active = 1;
                $u->MeetingConfig->save();
            }
        }
    }
}
