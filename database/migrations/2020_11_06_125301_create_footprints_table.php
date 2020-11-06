<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFootprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footprints', function (Blueprint $table) {
            $table->increments('id');
            $table->double('activity', 8, 2)->nullable(false);
            $table->enum('activityType', ['miles', 'fuel'])->nullable(false);
            $table->enum('country', ['usa', 'gbr', 'def'])->nullable(false);
            $table->enum('fuelType', ['motorGasoline', 'diesel', 'aviationGasoline', 'jetFuel'])->nullable(true);
            $table->enum('mode', ['dieselCar', 'petrolCar', 'anyCar', 'taxi', 'economyFlight', 'businessFlight', 'firstclassFlight', 'anyFlight', 'motorbike', 'bus', 'transitRail'])->nullable(true);
            $table->string('response');
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
        Schema::dropIfExists('footprints');
    }
}
