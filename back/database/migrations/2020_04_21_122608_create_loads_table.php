<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->string('REF');
            $table->double('amount');
            $table->date('DATE_LOAD');
            $table->integer('load_related_to')->unsigned();
            $table->foreign('load_related_to')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->enum('TVA', [20, 14])->nullable();

            $table->string('load_types_name');
            $table->foreign('load_types_name')->references('name')->on('load_types')
                ->onUpdate('cascade')->onDelete('cascade');

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
        Schema::dropIfExists('loads');
    }
}
