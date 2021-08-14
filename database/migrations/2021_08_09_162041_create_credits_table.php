<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('credits', function (Blueprint $table) {
            $table->bigIncrements('idCredit');
            $table->bigInteger('amount');
            $table->double('rate');
            $table->integer('duration');
            $table->string('signature',1000)->nullable();
            $table->string('publicKey',1000)->nullable();
            $table->double('monthly');
            $table->string('Client_CIN_Number');
            $table->foreign('Client_CIN_Number')->references('CIN_Number')->on('clients');
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
        Schema::dropIfExists('credits');
        Schema::table('credits', function (Blueprint $table) {
            $table->dropForeign('credits_Client_CIN_Number_foreign');
        });
    }
}
