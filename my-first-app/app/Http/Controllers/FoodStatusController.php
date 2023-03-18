<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food_Status;

class FoodStatusController extends Controller
{
    function index() {
        $food_now_status = Food_Status::first();
        return view('home')->with('food_now_status', $food_now_status);
    }
}
