<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppartementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appartements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('immeuble_id');
            $table->integer('numero_etage');
            $table->integer('numero_appartement');
            $table->string('numero');
            $table->double('superficie');
            $table->integer('nbr_chambre');
            $table->double('prix_previsionnel');
            $table->enum('type',['Disponible','Vendu'])->default('Disponible');
            $table->foreign('immeuble_id')->references('id')->on('immeubles')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('appartements');
    }
}
