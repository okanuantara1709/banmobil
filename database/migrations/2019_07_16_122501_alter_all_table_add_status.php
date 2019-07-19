<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAllTableAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user', function(Blueprint $table){
            $table->string('status')->default('Aktif');
        });
        Schema::table('rekening', function(Blueprint $table){
            $table->string('status')->default('Aktif');
        });
        Schema::table('lpj', function(Blueprint $table){
            $table->string('status')->default('Aktif');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
