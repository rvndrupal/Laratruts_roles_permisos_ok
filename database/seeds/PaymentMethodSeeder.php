<?php

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\PaymentMethod::class)->create([
            'name' => 'Stripe',
            'description' => 'Aceptamos el método de pago a través de tarjeta de crédito con Stripe'
        ]);
    }
}
