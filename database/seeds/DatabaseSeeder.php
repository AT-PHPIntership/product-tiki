<?php

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
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(UserInfoTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderDetailsTableSeeder::class);
        $this->call(ImagesTableSeeder::class);
        $this->call(NoteOrderTableSeeder::class);
        $this->call(AddressUserTableSeeder::class);
    }
}
