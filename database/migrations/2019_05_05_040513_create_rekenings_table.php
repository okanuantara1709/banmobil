<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRekeningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekening', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('satker_id')->unsigned();
            $table->string('nama_rekening');
            $table->string('no_rekening');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('satker_id')->references('id')->on('satker');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rekening');
    }
}
