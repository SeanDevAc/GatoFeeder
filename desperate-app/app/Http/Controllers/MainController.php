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
    function index() { //om alles mee te geven aan de home view.
        $food_status = FoodStatus::first(); // hier is er maar 1 waarde van
        $stock_info = StockInfo::latest('id')->first(); // wordt eerst gesorteerd op ID en dan de eerste gepakt; de nieuwste waarde dus
        $tray_info = TrayInfo::latest('id')->first();
        $food_timers = FoodTimer::all(); // alle rows van de timer tabel worden meegegeven, zodat we hierover kunnen itereren in de home view met Blade

        return view('home')->
            with('food_status', $food_status)->
            with('stock_info', $stock_info)->
            with('tray_info', $tray_info)->
            with('food_timers', $food_timers)
            ;
    }
}
