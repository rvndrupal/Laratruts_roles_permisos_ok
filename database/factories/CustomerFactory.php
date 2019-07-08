<?php

use Faker\Generator as Faker;

$factory->define(App\Customer::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'created_at' => $faker->dateTimeBetween('-3 months', 'now')
    ];
});
