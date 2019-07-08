<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'notes' => $faker->paragraph,
        'customer_id' => \App\Customer::all()->random()->id,
        'payment_method_id' => \App\PaymentMethod::all()->random()->id,
        'cost' => $faker->randomFloat(2, 5, 50),
        'created_at' => $faker->dateTimeBetween('-2 months', 'now')
    ];
});
