<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaporanPertanggungJawabansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpj', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('satker_id')->unsigned();
            $table->string('bulan');
            $table->integer('tahun');
            $table->date('tanggal_input');
            $table->date('tanggal_dokumen');
            $table->string('no_dokumen');
            $table->double('bp_kas',15,2)->default(0.0);
            $table->double('bp_uang',15,2)->default(0.0);
            $table->double('bp_bpp',15,2)->default(0.0);
            $table->double('bp_up',15,2)->default(0.0);
            $table->double('bp_is_bendahara',15,2)->default(0.0);
            $table->double('bp_pajak',15,2)->default(0.0);
            $table->double('bp_lain_lain',15,2)->default(0.0);
            $table->double('saldo',15,2)->default(0,0);
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
        Schema::dropIfExists('lpj');
    }
}
