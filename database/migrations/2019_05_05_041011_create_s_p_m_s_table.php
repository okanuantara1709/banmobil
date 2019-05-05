<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSPMSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spm', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('rekening_id')->unsigned();
            $table->string('jenis_pengeluaran');
            $table->text('uraian');
            $table->double('nominal',15,2)->default(0.0);
            $table->date('tgl');
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
        Schema::dropIfExists('spm');
    }
}
