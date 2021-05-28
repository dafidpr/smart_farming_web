<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_histories', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number')->nullable();
            $table->string('temperature')->nullable();
            $table->string('humidity')->nullable();
            $table->string('voltage')->nullable();
            $table->string('current')->nullable();
            $table->string('power')->nullable();
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
        Schema::dropIfExists('sensor_histories');
    }
}
