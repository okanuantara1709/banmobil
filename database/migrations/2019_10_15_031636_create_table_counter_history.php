<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCounterHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counter_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('counter_services_id')->unsigned();
            $table->datetime('datetime');
            $table->foreign('counter_services_id')->references('id')->on('counter_services');
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
        Schema::dropIfExists('counter_history');
    }
}
