<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Meta::class, function (Faker $faker) {
    return [
        'key' => $faker->unique()->word
    ];
});
