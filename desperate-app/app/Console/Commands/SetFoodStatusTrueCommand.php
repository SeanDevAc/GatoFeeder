<?php

namespace App\Console\Commands;

use App\Models\FoodStatus;
use App\Models\FoodTimer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetFoodStatusTrueCommand extends Command
{
    protected $signature = 'command:foodyes'; // de naam van de command. kan aangeroepen worden voor debugging purposes: 'php artisan command:foodyes'
    protected $description = 'Set FoodStatus to true'; // description van de command

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $food_status = FoodStatus::first();
        $food_timers = FoodTimer::all();
        foreach ($food_timers as $timer) { // wordt gecheckt voor elke timer 
            $time_to_execute = Carbon::parse($timer->time_to_execute)->shiftTimezone('Europe/Amsterdam'); 
            if ($time_to_execute->isCurrentMinute() && $timer->enabled) {
                $food_status->food_now_flag = true;
                $food_status->how_much_food = $timer->amount_in_grams;
                $food_status->save();
            }
        }
        echo $food_status->food_now_flag;
        return 0;
    }
}
