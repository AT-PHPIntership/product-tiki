<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\Category', 5)->create();
        factory('App\Models\Category', 10)->states('parent')->create();
        factory('App\Models\Category', 10)->states('parent')->create();
    }
}
