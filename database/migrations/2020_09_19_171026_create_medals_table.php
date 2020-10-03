<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medals', function (Blueprint $table) {
            $table->id();
            $table->string('name_medal');
            $table->string('icon_medal')->nullable();
            $table->double('reward_medal')->nullable();
            $table->bigInteger('max_penarikan')->nullable();
            $table->bigInteger('min_saldo')->nullable();
            $table->string('persyaratan_medal')->nullable();
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
        Schema::dropIfExists('medals');
    }
}
