<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessManagementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_managements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();
            $table->date('DATE_ENTRY');
            $table->date('DATE_LAI');
            $table->boolean('ttc')->default(0)->change();
            $table->bigInteger('membership_id')->nullable();
            $table->string('membership_type')->nullable();
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
        Schema::dropIfExists('business_managements');
    }
}
