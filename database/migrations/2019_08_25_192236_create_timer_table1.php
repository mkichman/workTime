<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimerTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userId')->nullable(false);
            $table->timestamps();
            $table->time('startTime');
            $table->time('endTime');
            $table->date('startDate');
            $table->date('endDate');
            $table->integer('break');
            $table->integer('workTime')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timers');
    }
}
