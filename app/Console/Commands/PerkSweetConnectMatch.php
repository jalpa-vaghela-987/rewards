<?php

namespace App\Console\Commands;

use App\Http\Controllers\MeetingController;
use App\Models\Company;
use Illuminate\Console\Command;

class PerkSweetConnectMatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'connect:match';

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
        $mc = new MeetingController;
        $companies = Company::all();
        foreach ($companies as $c) {
            $mc->match($c);
        }
    }
}
