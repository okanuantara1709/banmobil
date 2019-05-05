<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rekening_id')->unsigned();
            $table->string('tipe');
            $table->string('nama');
            $table->double('jumlah',15,2)->default(0.0);
            $table->date('tgl');
            $table->string('metode_pembayaran');
            $table->string('status');
            $table->timestamps();

            $table->foreign('rekening_id')->references('id')->on('rekening');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
