<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Order::class, function (Faker $faker) {
    $status = $faker->numberBetween($min = 0, $max = 3);
    return [
        'user_id' => App\Models\User::all()->random()->id,
        'status' => $status,
        'note' => $status ? $faker->text($maxNbChars = 500) : ''
    ];
});
