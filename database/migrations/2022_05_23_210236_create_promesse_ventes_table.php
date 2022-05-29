<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromesseVentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promesse_ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->unique();
            $table->unsignedBigInteger('appartement_id');
            $table->double('tauxTVA');
            $table->double('prixVenteDefinitifHT');
            $table->double('prixVenteDefinitifTTC');
            $table->double('avance');
            $table->enum('etat',['En cours','Annuler'])->default('En cours');
            //$table->string('nom_promesse');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('appartement_id')->references('id')->on('appartements')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('promesse_ventes');
    }
}
