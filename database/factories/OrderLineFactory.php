<?php

use Faker\Generator as Faker;

$factory->define(App\OrderLine::class, function (Faker $faker) {
    return [
        'product_id' => \App\Product::all()->random()->id,
        'qty' => $faker->numberBetween(1, 5)
    ];
});
