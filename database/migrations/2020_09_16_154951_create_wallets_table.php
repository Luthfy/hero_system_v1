<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_wallet')->unique();
            $table->bigInteger('heropay_wallet')->unsigned()->default(0);
            $table->bigInteger('heropoin_wallet')->unsigned()->default(0);
            $table->bigInteger('herobonus_wallet')->unsigned()->default(0);
            $table->uuid('uuid_member')->index();
            $table->uuid('uuid_level_member')->index();
            $table->timestamps();

            $table->foreign('uuid_member')->references('uuid_member')->on('members')->onUpdate('cascade');
            $table->foreign('uuid_level_member')->references('uuid_level_member')->on('level_members')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallets');
    }
}
