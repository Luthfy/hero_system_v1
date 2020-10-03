<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatasanPenarikanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batasan_penarikan', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_batasan');
            $table->integer('besaran_batasan');
            $table->string('estimasi_waktu_batasan');
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
        Schema::dropIfExists('batasan_penarikan');
    }
}
