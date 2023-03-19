<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldertechesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folderteches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->string('REF');
            $table->string('PTE_KNOWN');
            $table->string('TIT_REQ');
            $table->string('place');
            $table->date('DATE_ENTRY');
            $table->date('DATE_LAI');
            $table->integer('UNITE');
            $table->boolean('ARCHIVE')->default(0)->change();
            $table->boolean('isValidate')->default(0)->change();
            $table->boolean('isPayed')->default(0)->change();
            $table->double('PRICE');
            $table->integer('Inter_id');

            $table->integer('Inter_id')->unsigned();
            $table->foreign('Inter_id')->references('id')->on('intermediates')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('folder_sit_id')->unsigned();
            $table->foreign('folder_sit_id')->references('id')->on('foldertechsituations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('client_id')->unsigned();
            $table->foreign('client_id')->references('id')->on('clients')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->integer('resp_id')->unsigned();
            $table->foreign('resp_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->string('nature_name');
            $table->foreign('nature_name')->references('Name')->on('folder_tech_natures')
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
        Schema::dropIfExists('folderteches');
    }
}
