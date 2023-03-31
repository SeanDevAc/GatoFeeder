<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LedController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\FoodStatusController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StockInfoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// //Route::get('/', [LedController::class, 'index']);
// Route::get('/toggle_led', [LedController::class, 'toggle_led']);
// Route::get('/get_led_state', [LedController::class, 'get_led_state']);
// Route::get('/button_pressed', [CountController::class, 'button_pressed']);

// als /, dan callt het 'index' in class FoodStatusController
Route::get('/', [MainController::class, 'index']); 
Route::get('/food_now_true', [FoodStatusController::class, 'food_now_true']);
Route::get('/food_is_given', [FoodStatusController::class, 'food_is_given']);

//Route::get('/set_stock_weight/{weight}', [StockInfoController::class,  'set_stock_weight'])->whereNumber('weight');
Route::post('/set_stock_weight', [StockInfoController::class, 'set_stock_weight']);