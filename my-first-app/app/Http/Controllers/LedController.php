<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Count;
use App\Models\Led;

class LedController extends Controller
{
    function index() {
        //$count = Count::where('id', 3);
        $count = Count::first();
        $led = Led::first();
        return view('home')->with('count', $count)->with('led', $led);
    }

    public function toggle_led() {
        $led = Led::first();

        if ($led->led_is_on == true) {
            $led->led_is_on = false;
        } else {
            $led->led_is_on = true;
        }
        
        $led->save();

        return redirect('/');

    }

    public function get_led_state() {
        $led_state = Led::first();
        return $led_state->led_is_on;
    }

}
