<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Generator as Faker;

class UserInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $idUsers = User::pluck('id')->toArray();
        for ($i = 0; $i < 10; $i++) {
            factory(App\Models\UserInfo::class,1)->create([
                'user_id' => $faker->unique()->randomElement($idUsers),     
            ]);
        }
        
    }
}
