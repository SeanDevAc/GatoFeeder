<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LedController;
use App\Http\Controllers\CountController;
use App\Http\Controllers\FoodStatusController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\StockInfoController;
use App\Http\Controllers\TrayInfoController;
use App\Http\Controllers\FoodTimersController;

Route::get('/', [MainController::class, 'index'])->middleware(['auth'])->name('index'); 
Route::get('/food_now_true', [FoodStatusController::class, 'food_now_true']);
Route::post('/set_new_timer', [FoodTimersController::class, 'set_new_timer'])->middleware(['auth']);
Route::delete('/remove_timer/{id}', [FoodTimersController::class, 'remove_timer'])->name('food_timer.remove')->middleware(['auth']);

Route::get('/food_is_given', [FoodStatusController::class, 'food_is_given']);
Route::get('/check_food_state', [FoodStatusController::class, 'check_food_state']);
Route::get('/check_food_amount', [FoodStatusController::class, 'check_food_amount']);

//Route::get('/set_stock_weight/{weight}', [StockInfoController::class,  'set_stock_weight'])->whereNumber('weight');
Route::post('/set_stock_weight', [StockInfoController::class, 'set_stock_weight']);
Route::post('/set_tray_weight', [TrayInfoController::class, 'set_tray_weight']);



require __DIR__.'/auth.php';