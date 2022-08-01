<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGreatconstructionsiteAllocatedbrigadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->down();
        Schema::create('g_c_s_a_b', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->bigInteger('g_c_id')->unsigned();
            $table->foreign('g_c_id')->references('id')->on('g_c_s')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->bigInteger('a_b_id')->unsigned();
            $table->foreign('a_b_id')->references('id')->on('allocated_brigades')
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
        Schema::dropIfExists('g_c_s_a_b');
    }
}
