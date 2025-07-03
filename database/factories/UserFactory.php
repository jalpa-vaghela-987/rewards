<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    protected $titles = [
        'Administrative Assistant',
        'Outside Advisor',
        'Financial Analyst',
        'Systems Architect',
        'Executive Assistant',
        'Associate',
        'Sales Associate',
        'Team Lead',
        'Marketing Associate',
        'Support Associate',
        'M&A Associate',
        'Accountant',
        'Tax Accountant',
        'Chief Executive',
        'Consultant',
        'Event Coordinator',
        'Designer',
        'Lead Designer',
        'Developer',
        'Lead Developer',
        'Engineer',
        'Sales Liason',
        'Maintainer',
        'Manager',
        'Compliance Officer',
        'Inventory Planner',
        'Producer',
        'Researcher',
        'Director',
        'Client Specialist',
        'Supervisor',
        'Customer Support',
        'Sales Technician',
    ];

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $name = $firstName.' '.$lastName;

        $k = array_rand($this->titles);
        $v = $this->titles[$k];

        $start = strtotime('1940-01-01');
        $end = time();
        $timestamp = mt_rand($start, $end);
        $bday = date('Y-m-d H:i:s', $timestamp);
        $start = strtotime('1980-01-01');
        $end = time();
        $timestamp = mt_rand($start, $end);
        $anniversary = date('Y-m-d H:i:s', $timestamp);

        return [
            'first_name'            => $firstName,
            'last_name'             => $lastName,
            'name'                  => $name,
            'initials'              => get_initials($name),
            'email'                 => $firstName.'.'.$lastName.'@pp.com',
            'position'              => $v,
            'email_verified_at'     => now(),
            'password'              => bcrypt('z'), // password
            'remember_token'        => Str::random(10),
            'last_login'            => $this->rand_date(now()->subMonths(3), now()),
            'created_at'            => $this->rand_date(now()->subMonths(12), now()),
            'background_photo_path' => '/other/piedpiper.png',
            'level' => 2,
            'company_id' => 1, // note this is how the companies are linked
            'birthday' => $bday,
            'anniversary' => $anniversary,
        ];
    }

    public function rand_date($min_date, $max_date)
    {
        /* Gets 2 dates as string, earlier and later date.
           Returns date in between them.
        */

        $min_epoch = strtotime($min_date);
        $max_epoch = strtotime($max_date);

        $rand_epoch = rand($min_epoch, $max_epoch);

        return date('Y-m-d H:i:s', $rand_epoch);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
