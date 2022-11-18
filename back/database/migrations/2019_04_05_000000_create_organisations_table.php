<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name");
            $table->string("ICE");
            $table->string("emailOrganisation")->unique();
            $table->string("description");
            $table->string("owner")->nullable();
            $table->integer("cto")->unsigned();
            $table->string("file_avatar_name")->nullable();
            $table->string("link1")->nullable();
            $table->string("link2")->nullable();
            $table->string("link3")->nullable();
            $table->string("link4")->nullable();
            $table->boolean("activer")->nullable();
            $table->string("desactiver")->nullable();
            $table->string("blocked")->nullable();
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("zip_code")->nullable();
            $table->string("tel")->nullable();

            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->integer('deleted_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('deleted_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cto')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organisations');
    }
}
