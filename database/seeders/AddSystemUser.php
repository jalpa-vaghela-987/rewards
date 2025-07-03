<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AddSystemUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'              => config('app.name'),
            'email'             => 'info@perksweet.com',
            'password'          => bcrypt('password'),
            'company_id'        => 1,
            'role'              => 0,
            'position'          => 'SuperAdmin',
            'email_verified_at' => now(),
        ]);
    }
}
