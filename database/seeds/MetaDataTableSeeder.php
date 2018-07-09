<?php

use Illuminate\Database\Seeder;

class MetaDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\MetaData', 50)->create();
    }
}
