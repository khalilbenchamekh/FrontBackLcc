<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGreatconstructionsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('g_c_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->double('price');
            $table->double('fees_decompte');

            $table->bigInteger('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('Market_title')->unique();

            $table->integer('resp_id')->unsigned();
            $table->foreign('resp_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->enum('State_of_progress', ['En cours', 'Teminé', 'En Attente de validation', 'Annulé'])->nullable();
            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('Class_service')->nullable();
            $table->string('Execution_report')->nullable();
            $table->text('Execution_phase')->nullable();

            $table->Date('date_of_receipt');
            $table->Date('DATE_LAI');

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
        Schema::dropIfExists('g_c_s');
    }
}
