<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePpobTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppob_transaction', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid_ppob_transaction')->unique();
            $table->string('trxid')->nullable();
            $table->string('api_trxid');
            $table->uuid('uuid_user')->nullable();
            $table->integer('user_type')->default(0);
            $table->integer('status')->default(0);
            $table->string('message')->nullable();
            $table->json('data_detail')->nullable();
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
        Schema::dropIfExists('ppob_transaction');
    }
}
