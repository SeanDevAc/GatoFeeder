<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrayInfo;

class TrayInfoController extends Controller
{
    public function set_tray_weight(Request $request) { //zelfde verhaal als bij StockInfoController maar is ongebruikt
        $weight = $request->tray_weight;
        $tray_info = new TrayInfo;
        $tray_info->tray_weight_grams = $weight;
        $tray_info->save();
        return $weight;
    }
}
