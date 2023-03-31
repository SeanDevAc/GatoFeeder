<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodStatus;

class FoodStatusController extends Controller
{
    public function food_now_true() {
        $food_status = FoodStatus::first();
        

        if (!($food_status->food_now_flag)) { //als food_status = 0 oftewel happy flow
            $food_status->food_now_flag = true; 
            $food_status->save();
            return redirect('/');
        }
        // bad flow: food_now_flag is already 1
        //$food_status->food_now_flag = false;
        //$food_status->save();
        return 'food_now_flag is already 1 ';
    }

    public function food_is_given() {
        $food_status = FoodStatus::first();

        if ($food_status->food_now_flag) { // if flag is still on 1. happy flow
            $food_status->food_now_flag = false;
            $food_status->save();
            return 0;
        } 
        // bad flow: food_now_flag is already 0. extra food has been given
        return 'food_now_flag is already set to 0. check your cat!!!';
    }

    public function check_food_state() {
        $food_status = FoodStatus::first();
        return $food_status->food_now_flag;
    }
}
