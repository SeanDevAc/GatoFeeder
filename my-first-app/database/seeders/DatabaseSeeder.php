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
        DB::table('food_status')->insert([
            'food_now_flag' => false,
            'how_much_food' => 0,
        ]);

        DB::table('stock_infos')->insert([
            'stock_weight_grams' => 0,
        ]);

        DB::table('tray_infos')->insert([
            'tray_weight_grams' => 0,
        ]);

        DB::table('food_timers')->insert([ //test values.
            'time_to_execute' => '07:00:00',
            'amount_in_grams' => 40,
            'enabled' => true,
        ]);
        
        DB::table('food_timers')->insert([
            'time_to_execute' => '13:00:00',
            'amount_in_grams' => 60,
            'enabled' => false,
        ]);
    }
}
