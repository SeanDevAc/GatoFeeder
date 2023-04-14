<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodStatus;
use App\Models\StockInfo;
use App\Models\TrayInfo;
use App\Models\FoodTimer;

class FoodStatusController extends Controller
{
    public function food_now_true() { //eigenlijk alleen Feed Now UI knop
        $food_status = FoodStatus::first();

        if (!($food_status->food_now_flag)) { //als food_status = 0 oftewel happy flow
            $food_status->food_now_flag = true; 
            $food_status->how_much_food = 15;
            $food_status->save();
            return redirect('/');
        }
        // bad flow: food_now_flag is already 1
        //return view('home')->with('message', 'food_now_flag is already 1 ');
        //return back()->with('message', 'double request');
        $food_status = FoodStatus::first();
        $stock_info = StockInfo::latest('id')->first();
        $tray_info = TrayInfo::latest('id')->first();
        //return $tray_info;
        $food_timers = FoodTimer::all();
        $message = 'you already pressed this, heb ff geduld';

        return view('home')->
            with('food_status', $food_status)->
            with('stock_info', $stock_info)->
            with('tray_info', $tray_info)->
            with('food_timers', $food_timers)
           ->with('message', $message)
            ;
    }

    public function food_is_given() { // deze is om de food flag weer naar 0 te zetten. dit doet de ESP, niet de user
        $food_status = FoodStatus::first();

        if ($food_status->food_now_flag) { // if flag is still on 1. happy flow
            $food_status->food_now_flag = false;
            $food_status->how_much_food = 0;
            $food_status->save();
            return 0;
        } 
        // bad flow: food_now_flag is already 0. extra food has been given
        return 'food_now_flag is already set to 0. check your cat!!!'; // debugging purposes voor de ESP.
    }

    public function check_food_state() { // returnt of er eten gegeven moet worden. deze wordt elke halve  minuut gecheckt door de ESP
        $food_status = FoodStatus::first();
        return $food_status->food_now_flag;
    }

    public function check_food_amount() { // returnt hoeveel eten er gegeven mag worden, ook voor de ESP
        $food_status = FoodStatus::first();
        return $food_status->how_much_food;
    }
}
