<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_customer')->unique();
            $table->string('email_customer');
            $table->string('username_customer');
            $table->string('password_customer');
            $table->string('name_customer');
            $table->date('birthday_customer')->nullable();
            $table->string('photo_customer')->nullable();
            $table->string('idcard_customer')->nullable();
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
        Schema::dropIfExists('customers');
    }
}
