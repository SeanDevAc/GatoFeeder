<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoodStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_status', function (Blueprint $table) {
            $table->id();
            $table->boolean('food_now_flag'); // 0 or 1. 1 means ESP device needs to give food now. why no boolean?? uhhh zo aangeleerd door docent
            $table->timestamps(); //default. creates created_at and updated_at TIMESTAMP columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_status');
    }
}
