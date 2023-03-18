<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockInfo;

class StockInfoController extends Controller
{
    // here: specific StockInfo methods that aren't handled by FoodStatusController 
    public function set_stock_weight(int $weight) {
        $stock_info = new StockInfo;
        $stock_info->stock_weight_grams = $weight;
        $stock_info->save();

        // StockInfo::create([
        //     'stock_weight_grams' => $weight,
        // ]);
        return $weight;
    }
}
