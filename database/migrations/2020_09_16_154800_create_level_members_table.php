<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLevelMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('level_members', function (Blueprint $table) {
            $table->id();
            $table->string('name_level_member');
            $table->bigInteger('poin_level_member')->default(0);
            $table->integer('bonus_sponsor')->default(0);
            $table->string('description_level_member')->nullable();
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
        Schema::dropIfExists('level_members');
    }
}
