<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntermediatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intermediates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->string('name');
            $table->string('second_name');
            $table->string('Street');
            $table->string('Street2');
            $table->string('city');
            $table->string('ZIP code');
            $table->string('Country');
            $table->string('Function');
            $table->string('tel');
            $table->string('Cour');
            $table->enum('fees', ['inclusive', 'Percentage'])->nullable();
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
        Schema::dropIfExists('intermediates');
    }
}
