<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockInfo;

class StockInfoController extends Controller
{
    public function set_stock_weight(Request $request) { // wordt aangeroepen door de ESP, om het gewicht te updaten. 
        $weight = $request->stock_weight;
        $stock_info = new StockInfo;
        $stock_info->stock_weight_grams = $weight;
        $stock_info->save();
        return $weight;
    }
}
