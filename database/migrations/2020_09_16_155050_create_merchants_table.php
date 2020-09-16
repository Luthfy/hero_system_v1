<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_merchant')->unique();
            $table->string('email_merchant');
            $table->string('username_merchant');
            $table->string('password_merchant');
            $table->string('name_merchant');
            $table->date('birthday_merchant')->nullable();
            $table->string('photo_merchant')->nullable();
            $table->string('fcm')->nullable();
            $table->string('status')->default(0);
            $table->uuid('uuid_member')->index();
            $table->timestamps();

            $table->foreign('uuid_member')->references('uuid_member')->on('members')->cascadeOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
