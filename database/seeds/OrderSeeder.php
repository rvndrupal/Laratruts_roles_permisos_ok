<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Order::class, 200)->create()
            ->each(function (\App\Order $o) {
                factory(\App\OrderLine::class, 2)->create(['order_id' => $o->id]);
            });
    }
}
