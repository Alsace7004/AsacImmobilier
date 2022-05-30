<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratVenteDefinitifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contrat_vente_definitifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('avocat_id');
            $table->unsignedBigInteger('promesse_vente_id');
            //$table->unsignedBigInteger('promesse_vente_appartement_id');
            //$table->unsignedBigInteger('promesse_vente_client_id');
            $table->string('description_appartement');
            $table->double('prix_vente');
            $table->string('type_payement');
            $table->string('signature_acquereur');
            $table->string('signature_directeur_commercial');

            $table->foreign('avocat_id')->references('id')->on('avocats')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('promesse_vente_id')->references('id')->on('promesse_ventes')->onUpdate('cascade')->onDelete('cascade');
            //$table->foreign('promesse_vente_appartement_id')->references('appartement_id')->on('promesse_ventes')->onUpdate('cascade')->onDelete('cascade');
            //$table->foreign('promesse_vente_client_id')->references('client_id')->on('promesse_ventes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('contrat_vente_definitifs');
    }
}
