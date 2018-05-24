<?php

use Faker\Generator as Faker;

$factory->define(App\Models\OrderDetail::class, function (Faker $faker) {
    $randomProduct = App\Models\Product::all()->random();
    $randomOrder = App\Models\Order::all()->random();
    $quantity = $faker->numberBetween($min = 1, $max = 10);
    $randomOrder->total = $randomOrder->total + ($randomProduct->price * $quantity);
    $randomOrder->save();
    return [
        'product_id' => $randomProduct->id,
        'order_id' => $randomOrder->id,
        'quantity' => $quantity,
        'product_price' => $randomProduct->price
    ];
});
