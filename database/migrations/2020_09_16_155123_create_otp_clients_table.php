<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_clients', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->integer('code');
            $table->integer('user_type')->default('0');
            $table->uuid('uuid_user')->index();
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
        Schema::dropIfExists('otp_clients');
    }
}
