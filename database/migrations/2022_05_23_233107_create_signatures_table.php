<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('avocat_id');
            $table->unsignedBigInteger('promesse_vente_id')->unique();
            $table->string('signaturePromesseAcquereur');
            $table->string('signaturePromesseDirecteurCommercial');
            $table->foreign('avocat_id')->references('id')->on('avocats')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('promesse_vente_id')->references('id')->on('promesse_ventes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('signatures');
    }
}
