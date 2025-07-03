<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MeetingConfig;
use App\Models\Point;
use App\Models\Redemption;
use App\Models\Team;
use App\Models\Transaction;
use App\Models\User;
use Artisan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //////////////////////////////////////
        //// Variables that drive seeding //////
        // 200 users and 15 points_amount will be ~1hr

        $user_amount = 50;
        $point_amount = $user_amount * 20; // exponential with user amount beware

        ///////////////////////////////////////
        //\App\Models\User::factory(10)->withPersonalTeam()->create();
        //\App\Models\User::factory(10)->create();

        $superCompany = Company::factory()->create([
            'id'                 => '0',
            'name'               => 'PerkSweet',
            'alias'              => 'PerkSweet',
            'using_connect'      => 1,
            'enable_slack'       => 1,
            'in_trial_mode'      => 0,
            'allow_tango_cards'  => 1,
            'verified'           => 1,
            'balance'            => 400,
            'cumulative_balance' => 400,
            'last_added_balance' => 400,
            'balance_updated'    => now(),
            'slack_webhook'      => 'https://hooks.slack.com/services/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',
        ]);

        // creates one fake company

        // creates the real users

        $nl = User::factory()->create([
            'first_name' => 'Nick',
            'last_name'  => 'Lynch',
            'name'       => 'Nick Lynch',
            'initials'   => 'NL',
            'email'      => 'nick@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $hl = User::factory()->create([
            'first_name' => 'Pankaj',
            'last_name'  => 'Godhani',
            'name'       => 'Pankaj Godhani',
            'initials'   => 'PG',
            'email'      => 'pankaj@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $bn = User::factory()->create([
            'first_name' => 'Ben',
            'last_name'  => 'Nussbaum',
            'name'       => 'Ben Nussbaum',
            'initials'   => 'BN',
            'email'      => 'ben@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $rn = User::factory()->create([
            'first_name' => 'Ritika',
            'last_name'  => 'Nikhara',
            'name'       => 'Ritika Nikhara',
            'initials'   => 'RN',
            'email'      => 'ritika@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '2',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $dg = User::factory()->create([
            'first_name' => 'Dilip',
            'last_name'  => 'Godhani',
            'name'       => 'Dilip Godhani',
            'initials'   => 'DG',
            'email'      => 'dilip@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '2',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $cl = User::factory()->create([
            'first_name' => 'Chris',
            'last_name'  => 'Lynch',
            'name'       => 'Chris Lynch',
            'initials'   => 'CL',
            'email'      => 'chris@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $cw = User::factory()->create([
            'first_name' => 'Craig',
            'last_name'  => 'Waldie',
            'name'       => 'Craig Waldie',
            'initials'   => 'CW',
            'email'      => 'craig@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);

        $mh = User::factory()->create([
            'first_name' => 'Kevin',
            'last_name'  => 'Lynch',
            'name'       => 'Kevin Lynch',
            'initials'   => 'KL',
            'email'      => 'kevin@perksweet.com',
            'company_id' => '1',
            'role'       => '1',
            'level'      => '5',
            'developer'  => '1',
            'points'     => 0,
        ]);
        //creates a ton of teamless users - this makes sure the platform scales

        //User::factory(500)->create();

        // creates the three teams
        $nl_team = Team::create([
            'name'          => 'Business Team',
            'user_id'       => $nl->id,
            'personal_team' => 0,
        ]);

        $bn_team = Team::create([
            'name'          => 'Sales Team',
            'user_id'       => $nl->id,
            'personal_team' => 0,
        ]);

        $hl_team = Team::create([
            'name'          => 'Development Team',
            'user_id'       => $hl->id,
            'personal_team' => 0,
        ]);

        // populates the business team
        $nl_team->users()->attach($nl, ['role' => 'admin']);
        $nl_team->users()->attach($bn, ['role' => 'admin']);
        $nl_team->users()->attach($cl, ['role' => 'admin']);
        $nl_team->users()->attach($mh, ['role' => 'admin']);
        $nl_team->users()->attach($cw, ['role' => 'admin']);

        // foreach (User::factory(15)->create() as $key => $value) {
        //     $nl_team->users()->attach(
        //         $value,
        //         ['role' => 'editor']
        //     );

        //     if ($key % 2 == 0) {
        //         $hl_team->users()->attach(
        //         $value,
        //         ['role' => 'editor']
        //     );
        //     }
        // }

        // populates the dev team
        $hl_team->users()->attach($hl, ['role' => 'admin']);
        $hl_team->users()->attach($nl, ['role' => 'admin']);
        $hl_team->users()->attach($dg, ['role' => 'admin']);
        $hl_team->users()->attach($rn, ['role' => 'admin']);
        $hl_team->users()->attach($cl, ['role' => 'editor']);

        foreach (User::factory(14)->create() as $key => $value) {
            $hl_team->users()->attach(
                $value,
                ['role' => 'editor']
            );

            // $p = Point::factory()->sendPoints($value, $nl);

            // $t = new Transaction;
            // $t->user()->associate($nl);
            // $t->point()->associate($p);
            // $t->note = $value->name.' sent you Kudos';
            // $t->link = '/received/'.$p->id;
            // $t->amount = $p->amount;
            // $t->type = 1;
            // $t->data = json_encode($p);
            // $t->save();
        }

        // populates the sales team
        $bn_team->users()->attach($bn, ['role' => 'admin']);
        $bn_team->users()->attach($nl, ['role' => 'admin']);
        $bn_team->users()->attach($cl, ['role' => 'admin']);
        $bn_team->users()->attach($mh, ['role' => 'admin']);

        foreach (User::factory(10)->create() as $key => $value) {
            $bn_team->users()->attach(
                $value,
                ['role' => 'editor']
            );
            // $p = Point::factory()->sendPoints($nl, $value);
            // //$value->sendPoints($bn);

            // $t = new Transaction;
            // $t->user()->associate($value);
            // $t->point()->associate($p);
            // $t->note = $nl->name.' sent you Kudos';
            // $t->link = '/received/'.$p->id;
            // $t->amount = $p->amount;
            // $t->type = 1;
            // $t->data = json_encode($p);
            // $t->save();
        }

        ///////// creates other fake companies for bug testing
        // $company = Company::factory()->create();
        // for ($i = 0; $i < 100; $i++) {
        //     $dg = User::factory()->create([
        //         'company_id' => '2',
        //      ]);
        // }

        // $company = Company::factory()->create();
        // for ($i = 0; $i < 100; $i++) {
        //     $dg = User::factory()->create([
        //         'company_id' => '3',
        //      ]);
        // }

        // $company = Company::factory()->create();
        // for ($i = 0; $i < 100; $i++) {
        //     $dg = User::factory()->create([
        //         'company_id' => '4',
        //      ]);
        // }

        //creates the rewards portion
        // Reward::factory(1)->create([
        //     'title'=> "$5 Amazon Gift Card",
        //     "description" => "$5 that can be used instantly on Amazon!",
        // ]);

        // Reward::factory(5)->create();

        ///////////////////////////////////
        //// njew demo company /////
        $superCompany2 = Company::factory()->create([
            'name'               => 'Pied Piper',
            'alias'              => 'PiedPiper',
            'using_connect'      => 1,
            'enable_slack'       => 1,
            'in_trial_mode'      => 0,
            'allow_tango_cards'  => 1,
            'balance'            => 400,
            'cumulative_balance' => 400,
            'last_added_balance' => 400,
            'balance_updated'    => now(),
            'verified'           => 1,
            'slack_webhook'      => 'https://hooks.slack.com/services/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',
        ]);

        // creates the real users

        $nl2 = User::factory()->create([
            'first_name' => 'Nick',
            'last_name'  => 'Lynch',
            'name'       => 'Nick Lynch',
            'initials'   => 'NL',
            'position'   => 'Senior Account Executive',
            'email'      => 'nick.lynch@pp.com',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '5',
            'points'     => 0,
        ]);

        $m = new MeetingConfig;
        $m->user()->associate($nl2);
        $m->interests = $this->select_interests();
        $m->expertise = $this->select_skills();
        $m->develop = $this->select_developments();
        $m->start_time = '9:00';
        $m->end_time = '17:00';
        $m->active = 1;
        $m->save();

        $kl = User::factory()->create([
            'first_name' => 'Kevin',
            'last_name'  => 'Brookmoor',
            'name'       => 'Kevin Brookmoor',
            'initials'   => 'KB',
            'email'      => 'kevin.brookmoor@pp.com',
            'position'   => 'Chief Financial Officer',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '4',
            'points'     => 0,
        ]);

        $m = new MeetingConfig;
        $m->user()->associate($kl);
        $m->interests = $this->select_interests();
        $m->expertise = $this->select_skills();
        $m->develop = $this->select_developments();
        $m->start_time = '9:00';
        $m->end_time = '17:00';
        $m->active = 1;
        $m->save();

        $cl = User::factory()->create([
            'first_name' => 'Chris',
            'last_name'  => 'Adams',
            'name'       => 'Chris Adams',
            'initials'   => 'CL',
            'email'      => 'chris.adams@pp.com',
            'position'   => 'Head of Sales',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '4',
            'points'     => 0,
        ]);

        $cw = User::factory()->create([
            'first_name' => 'Craig',
            'last_name'  => 'Waldie',
            'name'       => 'Craig Waldie',
            'initials'   => 'CL',
            'email'      => 'craig.waldie@pp.com',
            'position'   => 'Senior Account Executive',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '4',
            'points'     => 0,
        ]);

        $cw = User::factory()->create([
            'first_name' => 'Ben',
            'last_name'  => 'Nussbaum',
            'name'       => 'Ben Nussbaum',
            'initials'   => 'BN',
            'email'      => 'ben.nussbaum@pp.com',
            'position'   => 'Senior Account Executive',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '4',
            'points'     => 0,
        ]);

        $cw = User::factory()->create([
            'first_name' => 'Peter',
            'last_name'  => 'Stevens',
            'name'       => 'Peter Stevens',
            'initials'   => 'PS',
            'email'      => 'peter.stevens@pp.com',
            'position'   => 'Senior Account Executive',
            'company_id' => '2',
            'role'       => '1',
            'level'      => '4',
            'points'     => 0,
        ]);

        //creates a ton of teamless users - this makes sure the platform scales

        // creates the three teams
        $f_team = Team::create([
            'name'          => 'Finance Team',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);

        $f_team->users()->attach($kl, ['role' => 'admin']);
        $f_team->users()->attach($nl2, ['role' => 'admin']);

        $s_team = Team::create([
            'name'          => 'Sales Team',
            'user_id'       => $cl->id,
            'personal_team' => 0,
        ]);

        $s_team->users()->attach($nl2, ['role' => 'admin']);
        $s_team->users()->attach($cl, ['role' => 'admin']);

        $d_team = Team::create([
            'name'          => 'Development Team',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);
        $d_team->users()->attach($nl2, ['role' => 'admin']);

        $c_team = Team::create([
            'name'          => 'Culture Committee',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);
        $c_team->users()->attach($nl2, ['role' => 'admin']);

        $a_team = Team::create([
            'name'          => 'Accounting Department',
            'user_id'       => $kl->id,
            'personal_team' => 0,
        ]);
        $a_team->users()->attach($kl, ['role' => 'admin']);

        $hr_team = Team::create([
            'name'          => 'HR Team',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);
        $hr_team->users()->attach($nl2, ['role' => 'admin']);

        $support_team = Team::create([
            'name'          => 'Support Team',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);
        $support_team->users()->attach($nl2, ['role' => 'admin']);

        $admin_team = Team::create([
            'name'          => 'Admin Team',
            'user_id'       => $nl2->id,
            'personal_team' => 0,
        ]);

        $admin_team->users()->attach($nl2, ['role' => 'admin']);

        foreach (User::factory($user_amount)->create(['company_id' => '2']) as $key => $value) {
            if ($key % 35 == 0) {
                $c_team->users()->attach($value, ['role' => 'editor']);
            }
            if ($key % 35 == 1) {
                $c_team->users()->attach($value, ['role' => 'admin']);
            }
            switch ($value->position) {
                case 'Administrative Assistant':
                    $admin_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Executive Assistant':
                    $admin_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Financial Analyst':
                    $f_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'M&A Associate':
                    $f_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Tax Accountant':
                    $a_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Accountant':
                    $a_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Developer':
                    $d_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Designer':
                    $d_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Lead Developer':
                    $d_team->users()->attach($value, ['role' => 'admin']);
                    break;
                case 'Lead Designer':
                    $d_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Engineer':
                    $d_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Systems Architect':
                    $d_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Sales Liason':
                    $s_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Sales Associate':
                    $s_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Team Lead':
                    $s_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Sales Technician':
                    $s_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Client Specialist':
                    $s_team->users()->attach($value, ['role' => 'admin']);
                    break;
                case 'Customer Support':
                    $support_team->users()->attach($value, ['role' => 'editor']);
                    break;
                case 'Support Associate':
                    $support_team->users()->attach($value, ['role' => 'editor']);
                    break;

            }

            ///////// enrolls everyone in connect:

            $m = new MeetingConfig;
            $m->user()->associate($value);
            $m->interests = $this->select_interests();
            $m->expertise = $this->select_skills();
            $m->develop = $this->select_developments();
            $m->start_time = '9:00';
            $m->end_time = '17:00';
            $m->active = 1;
            $m->save();

            // $p = Point::factory()->sendPoints($value, $nl);

            // $t = new Transaction;
            // $t->user()->associate($nl);
            // $t->point()->associate($p);
            // $t->note = $value->name.' sent you Kudos';
            // $t->link = '/received/'.$p->id;
            // $t->amount = $p->amount;
            // $t->type = 1;
            // $t->data = json_encode($p);
            // $t->save();
        }

        //Point::factory(200)->create();

        foreach (Point::factory($point_amount)->create() as $key => $value) {
            $t = new Transaction;
            $t->user()->associate($value->receiver);
            $t->point()->associate($value);
            if ($value->isSpecial()) {
                $t->note = $value->giver->name.' sent you super Kudos';
            } else {
                $t->note = $value->giver->name.' sent you Kudos';
            }
            $t->link = '/received/'.$value->id;
            $t->amount = $value->amount;
            $t->type = 1;
            $t->data = json_encode($value);
            $t->created_at = $value->created_at;
            $t->save();

            $value->receiver->points += intval($value->amount);
            $value->receiver->save();
        }

        foreach (Redemption::factory($point_amount / 10)->create() as $key => $value) {
            $r = $value;
            $t = new Transaction;
            $t->user()->associate($r->user);
            $t->redemption()->associate($r);
            $reward = json_decode($r->data);
            $t->note = 'Purchased '.$r->tango_reward_name;
            $t->link = '/redemption/'.$r->id;
            $t->amount = -1 * (int) $r->cost;
            $t->type = 2;
            $t->created_at = $value->created_at;
            $t->data = json_encode($r);
            $t->save();

            $value->user_id = User::all()->where('company_id', 2)->where('points', '>', '3000')->random();
            $value->user->points -= intval($value->cost);
            //$value->created_at = $this->rand_date(now()->subMonths(4),now());
            if ($value->user->points < 0) {
                $value->user->points = 0;
            }
            $value->user->save();
        }

        //Point::factory()->sendPoints($bn,$nl);
        //Point::factory()->sendPoints($nl,$hl);

//        $this->call(AddSystemUser::class);
        //Artisan::call('refill:kudos_to_give');
        //Artisan::call('refill:kudos_to_give');

        // Artisan::call('connect:enroll_all_users 1');

        // Artisan::call('connect:match');
        // Artisan::call('connect:match');
        // Artisan::call('connect:match');
        // Artisan::call('connect:match');
//        Artisan::call('exchange-rates:update');
//        Artisan::call('tango:update');
        Artisan::call('refill:kudos_to_give');
        Artisan::call('queue:work --stop-when-empty');
        Artisan::call('connect:match');
        Artisan::call('connect:match');
    }

    public function select_interests()
    {
        $skills = collect([
            ' Livestreaming',
            ' Listening to music',
            ' Listening to podcasts',
            ' Lock picking',
            ' Machining',
            ' Macrame',
            ' Magic',
            ' Makeup',
            ' Manga',
            ' Massaging',
            ' Mazes (indoor/outdoor)',
            ' Mechanics',
            ' Meditation',
            ' Memory training',
            ' Metalworking',
            ' Miniature art',
            ' Minimalism',
            ' Model building',
            ' Model engineering',
            ' Music',
            ' Nail art',
            ' Needlepoint',
            ' Origami',
            ' Painting',
            ' Palmistry',
            ' Pen Spinning',
            ' Performance',
            ' Pet',
            ' Pet adoption & fostering',
            ' Pet sitting',
            ' Philately',
            ' Photography',
            ' Pilates',
            ' Planning',
            ' Plastic art',
            ' Playing musical instruments',
            ' Poetry',
            ' Poi',
            ' Pole dancing',
            ' Postcrossing',
            ' Pottery',
            ' Powerlifting',
            ' Practical jokes',
            ' Pressed flower craft',
            ' Proofreading and editing',
            ' Proverbs',
            ' Public speaking',
            ' Puppetry',
            ' Puzzles',
            ' Pyrography',
            ' Quilling',
            ' Quilting',
            ' Quizzes',
            ' Radio-controlled model playing',
            ' Rail transport modeling',
            ' Rapping',
            ' Reading',
            ' Recipe creation',
            ' Refinishing',
            ' Reiki',
            ' Reviewing Gadgets',
            ' Robot combat',
            ' Rubiks Cube',
            ' Scrapbooking',
            ' Scuba Diving',
            ' Sculpting',
            ' Sewing',
            ' Shoemaking',
            ' Singing',
            ' Sketching',
            ' Skipping rope',
            ' Slot car',
            ' Soapmaking',
            ' Social media',
            ' Spreadsheets',
            ' Sleeping',
            ' Stamp collecting',
            ' Stand-up comedy',
            ' Storytelling',
            ' Stripping',
            ' Sudoku',
            ' Table tennis playing',
            ' Tapestry',
            ' Tarot',
            ' Tatebanko',
            ' Tattooing',
            ' Telling jokes',
            ' Thrifting',
            ' Upcycling',
            ' Video editing',
            ' Video game developing',
            ' Video gaming',
            ' Video making',
            ' VR Gaming',
            ' Watch making',
            ' Watching documentaries',
            ' Watching movies',
            ' Watching television',
            ' Wax sealing',
            ' Waxing',
            ' Weaving',
            ' Webtooning',
            ' Weight training',
            ' Welding',
            ' Whisky',
            ' Whittling',
            ' Wikipedia editing',
            ' Wine tasting',
            ' Winemaking',
            ' Wood carving',
            ' Woodworking',
            ' Word searches',
            ' Worldbuilding',
            ' Writing',
            ' Writing music',
            ' Yo-yoing',
            ' Yoga',
            ' Zumba',
        ]);

        return $skills->random(4)->implode(',');
    }

    public function select_skills()
    {
        $skills = collect([

            ' Creative',
            ' Determinate',
            ' Dedicated',
            ' Enthusiastic',
            ' Flexible',
            ' Honest',
            ' Hard-working',
            ' Patient',
            ' Trustworthy',
            ' Team player',
            ' Quick learner',
            ' Versatile',
            ' Optimistic',
            ' Judiciousness',
            ' Multitasking',
            ' Expressive',
            ' Respectful',
            ' Innovative',
            ' Attentive',
            ' Empathetic',
        ]);

        return $skills->random(3)->implode(',');
    }

    public function select_developments()
    {
        $skills = collect([
            ' Time-management',
            ' Negotiation Skills',
            ' Organization Skills',
            ' Accuracy',
            ' Brevity',
            ' Clarity',
            ' Disciplined',
            ' I am Introverted',
            ' I Procrastinate',
            ' Being a shy person, it becomes difficult for me to question others at certain moments or enforce new rules and regulations.',
            ' Being sensitive to others needs, sometimes, people try to be manipulative with me. ',
            ' Being an open communicator, my style might be a bit blunt and brazen for others. ',
        ]);

        return $skills->random(2)->implode(', ');
    }
}
