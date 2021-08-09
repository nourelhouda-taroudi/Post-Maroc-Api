<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('CIN_front');
            $table->string('CIN_back');
            $table->string('salaryCertificate');
            $table->string('certificateResWaterElec');
            $table->string('jobCertificate');
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
        Schema::dropIfExists('documents');
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign('documents_Client_CIN_Number_foreign');
        });
    }
}
