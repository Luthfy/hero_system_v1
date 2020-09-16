<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_driver')->unique();
            $table->string('email_driver')->unique();
            $table->string('username_driver');
            $table->string('password_driver');
            $table->string('name_driver');
            $table->date('birthday_driver')->nullable();
            $table->string('photo_driver')->nullable();
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
        Schema::dropIfExists('drivers');
    }
}
