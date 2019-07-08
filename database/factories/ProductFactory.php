<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraph,
        'category_id' => \App\Category::all()->random()->id,
        'price' => $faker->randomFloat(2, 5, 50),
        'stock' => $faker->numberBetween(10, 200),
        'image' => \Faker\Provider\Image::image(storage_path('app/public/products'), 600, 350, 'sports', false),
        'created_at' => $faker->dateTimeBetween('-4 months', 'now')
    ];
});
