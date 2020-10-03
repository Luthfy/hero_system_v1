<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomisiTransaksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komisi_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_komisi');
            $table->integer('besaran_komisi');
            $table->string('jenis_besaran')->default('persen');
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
        Schema::dropIfExists('komisi_transaksi');
    }
}
