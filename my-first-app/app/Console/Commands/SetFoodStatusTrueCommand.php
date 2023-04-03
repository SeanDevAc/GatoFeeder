<?php

namespace App\Console\Commands;

use App\Models\FoodStatus;
use App\Models\FoodTimer;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SetFoodStatusTrueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:foodyes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set FoodStatus to true';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $food_status = FoodStatus::first();
        $food_timers = FoodTimer::all();
        foreach ($food_timers as $timer) {
            $time_to_execute = Carbon::parse($timer->time_to_execute)->shiftTimezone('Europe/Amsterdam');
            if ($time_to_execute->isCurrentMinute() && $timer->enabled) {
                $food_status->food_now_flag = true;
                $food_status->save();
            }
        }
        echo $food_status->food_now_flag;
        return 0;
    }
}
