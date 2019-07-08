<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Tag::class)->create(['name' => 'equipo de música']);
        factory(\App\Tag::class)->create(['name' => 'auriculares']);
        factory(\App\Tag::class)->create(['name' => 'ultraligeros']);
        factory(\App\Tag::class)->create(['name' => 'dvd']);
        factory(\App\Tag::class)->create(['name' => 'blu-ray']);
    }
}
