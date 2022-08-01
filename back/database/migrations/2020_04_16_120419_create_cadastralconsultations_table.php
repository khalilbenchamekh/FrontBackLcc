<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadastralconsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastralconsultations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->char('REQ_TIT',1);
            $table->integer('NUM')->nullable();
            $table->integer('INDICE')->nullable();
            $table->string('GENRE_OP')->nullable();
            $table->string('TITRE_MERE')->nullable();
            $table->string('REQ_MERE')->nullable();
            $table->string('X')->nullable();
            $table->string('Y')->nullable();
            $table->date('DATE_ARRIVEE')->nullable();
            $table->date('DATE_BORNAGE')->nullable();
            $table->string('RESULTAT_BORNAGE')->nullable();
            $table->string('BORNEUR')->nullable();
            $table->string('NUM_DEPOT')->nullable();
            $table->date('DATE_DEPOT')->nullable();
            $table->string('CARNET')->nullable();
            $table->string('BON')->nullable();
            $table->date('DATE_DELIVRANCE')->nullable();
            $table->integer('NBRE_FRACTION')->nullable();
            $table->string('PRIVE')->nullable();
            $table->string('OBSERVATIONS')->nullable();
            $table->date('DATE_ARCHIVE')->nullable();
            $table->integer('CONT_ARR')->nullable();
            $table->string('SITUATION')->nullable();
            $table->string('PTE_DITE')->nullable();
            $table->string('MAPPE')->nullable();
            $table->string('STATUT')->nullable();
            $table->string('COMMUNE')->nullable();
            $table->string('CONSISTANCE')->nullable();
            $table->string('CLEF')->nullable();
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
        Schema::dropIfExists('cadastralconsultations');
    }
}
