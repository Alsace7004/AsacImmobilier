<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesistementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desistements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promesse_vente_id')->unique();
            $table->string('numero');
            $table->string('causes_annulation');
            $table->foreign('promesse_vente_id')->references('id')->on('promesse_ventes')->onUpdate('cascade')->onDelet('cascade');
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
        Schema::dropIfExists('desistements');
    }
}
