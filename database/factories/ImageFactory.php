<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Image::class, function (Faker $faker) {
    return [
        'product_id' => App\Models\Product::all()->random()->id,
        'img_url' => 'img.jpg'
    ];
});
