<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrayInfosTable extends Migration
{
    public function up()
    {
        Schema::create('tray_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('tray_weight_grams');
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
        Schema::dropIfExists('tray_infos');
    }
}
