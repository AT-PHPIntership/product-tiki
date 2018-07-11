<?php

use Faker\Generator as Faker;

$factory->define(App\Models\AddressUser::class, function (Faker $faker) {
    return [
        'userinfo_id' => App\Models\UserInfo::all()->random()->id,
        'address' => $faker->address, 
    ];
});