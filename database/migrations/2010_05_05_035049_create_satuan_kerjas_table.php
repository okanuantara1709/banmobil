<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSatuanKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('satker', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_satker');
            $table->string('alamat');
            $table->string('email');
            $table->string('telepon');
            $table->text('kementrian_lembaga');
            $table->integer('no_krws_dan_kewenangan');
            $table->string('nama_bendahara');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('satker');
    }
}
