<?php

use Faker\Generator as Faker;

$factory->define(App\Models\MetaData::class, function (Faker $faker) {
    return [
        'meta_key' => App\Models\Meta::all()->random()->key,
        'meta_data' => $faker->text($maxNbChars = 100),
        'product_id' => App\Models\Product::all()->random()->id
    ];
});
