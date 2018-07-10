<?php

use Illuminate\Database\Seeder;

class AddressUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\AddressUser', 30)->create();
    }
}