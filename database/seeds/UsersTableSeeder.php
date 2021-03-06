<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\User', 10)->create();
        factory('App\Models\User')->create([
            'username' => 'test',
            'email' => 'admin@test.co',
            'password' => bcrypt('12345'), // secret
            'role' => App\Models\User::ADMIN_ROLE,
         ]);
    }
}
