<?php

use Faker\Generator as Faker;

$factory->define(App\ProductTag::class, function (Faker $faker) {
    return [
        'product_id' => \App\Product::all()->random()->id,
        'tag_id' => \App\Tag::all()->random()->id,
    ];
});
