<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrayInfo;

class TrayInfoController extends Controller
{
    public function set_tray_weight(Request $request) {
        $weight = $request->tray_weight;
        $tray_info = new TrayInfo;
        $tray_info->tray_weight_grams = $weight;
        $tray_info->save();
        return $weight;
    }
}
