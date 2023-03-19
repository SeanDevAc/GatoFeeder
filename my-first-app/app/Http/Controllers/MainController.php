<?php

namespace App\Http\Controllers;

//use DB;
use Illuminate\Http\Request;
use App\Models\FoodStatus;
use App\Models\StockInfo;
use App\Models\TrayInfo;
use App\Models\FoodTimer;

class MainController extends Controller
{
    function index() {
        $food_status = FoodStatus::first();
        $stock_info = StockInfo::latest('id')->first();
        $tray_info = TrayInfo::latest('id')->first();
        //return $tray_info;
        $food_timer = FoodTimer::first();

        return view('home')->
            with('food_status', $food_status)->
            with('stock_info', $stock_info)->
            with('tray_info', $tray_info)->
            with('food_timer', $food_timer)
            ;
    }
}
