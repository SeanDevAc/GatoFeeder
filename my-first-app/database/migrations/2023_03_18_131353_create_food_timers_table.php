<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_timers', function (Blueprint $table) {
            $table->id();
            $table->time('time_to_execute'); 
            $table->integer('amount_in_grams');
            $table->boolean('enabled'); //lets see if using boolean instead of integer breaks smth
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_timers');
    }
}
