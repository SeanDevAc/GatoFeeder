<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() // this runs when php artisan db:seed is executed
    {
        DB::table('leds')->insert([
            'led_is_on' => true,
        ]);

        DB::table('counts')->insert([
            'times_pressed' => 0,
        ]);

        DB::table('food_status')->insert([
            'food_now_flag' => 0,
        ]);

        DB::table('stock_weight')->insert([
            'stock_weight_gramsf' => 0,
        ]);
    }
}
