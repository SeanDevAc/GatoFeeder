<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodTimer;
use App\Models\FoodStatus;
use App\Models\StockInfo;
use App\Models\TrayInfo;

class FoodTimersController extends Controller
{
    // add a food timer
    public function set_new_timer(Request $request) {
        $validator = \Validator::make($request->all(), [ //valideert of de timer de juiste velden heeft en of deze kloppen
            'time_to_execute' => 'required|date_format:H:i|unique:food_timers,time_to_execute',
            'amount_in_grams' => 'required|integer',
            'timer_enabled' => 'nullable'
        ]);

        if ($validator->fails()) { // bad flow, returnt de home view met alle variabelen en een error-message
            $food_status = FoodStatus::first();
            $stock_info = StockInfo::latest('id')->first();
            $tray_info = TrayInfo::latest('id')->first();
            $food_timers = FoodTimer::all();
            $message = "there is already a timer at this time, or your amount of grams is invalid.";
            return view('home')->
            with('food_status', $food_status)->
            with('stock_info', $stock_info)->
            with('tray_info', $tray_info)->
            with('food_timers', $food_timers)
           ->with('message', $message)
            ;
        }

        $timer_enabled = true; //functionaleit die we hebben verwijderd omdat deze niet relevant is voor de gebruiker
        
        $time_to_execute = $request->time_to_execute;
        $amount_in_grams = $request->amount_in_grams;

        $food_timer = new FoodTimer;
        $food_timer->time_to_execute = $time_to_execute;
        $food_timer->amount_in_grams = $amount_in_grams;
        $food_timer->enabled = $timer_enabled;

        $food_timer->save();
        return redirect('/');
    }

    public function remove_timer($id) { // voor de delete request op de timer adhv id

        $food_timer = FoodTimer::findOrFail($id);
        $food_timer->delete();
        return redirect('/');
    }
}
