<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * type user
     * 0 = system
     * 1 = customer
     * 2 = driver
     * 3 = merchant
     * 4 = member
     * 5 = backoffice
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_activities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_log_activies')->unique();
            $table->integer('type_user')->default(0);
            $table->uuid('uuid_member_user')->index();
            $table->text('data')->nullable();
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
        Schema::dropIfExists('log_activities');
    }
}
