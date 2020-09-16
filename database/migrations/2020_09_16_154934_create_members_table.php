<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_member')->unique();
            $table->string('id_ref_member');
            $table->string('name_member', 100);
            $table->string('area_code_member', 4)->default('+62');
            $table->string('whatsapp_member', 25)->unique();
            $table->string('email_member')->unique();
            $table->string('password_member');
            $table->string('token_member', 6)->unique();
            $table->string('is_qualified', 1)->default(0);
            $table->string('refferal_member')->nullable();
            $table->string('status_member')->default('actived');
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
        Schema::dropIfExists('members');
    }
}
