<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockInfo;

class StockInfoController extends Controller
{
    // here: specific StockInfo methods that aren't handled by FoodStatusController 
    public function set_stock_weight(int $weight) {
        // iets van laatste entry pakken en dan timestamp vergelijken met current time?
        $stock_info = new StockInfo;
        $stock_info->stock_weight_grams = $weight;
        $stock_info->save();

        // StockInfo::create([
        //     'stock_weight_grams' => $weight,
        // ]);
        return $weight;
    }

    public function set_stock(Request $request) {
        //$weight = $request->input('weight');
        $weight = $request->weight;
        return $weight;
    }

}
