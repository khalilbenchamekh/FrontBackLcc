<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->text('auth_token')->nullable();
            $table->date('token_expired_at', 'Y-m-d')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('last_signin')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->enum('gender', ['male', 'female', ''])->nullable();
            $table->date('birthdate', 'Y-m-d')->nullable();
            $table->text('address')->nullable();
            $table->string('directory')->nullable();
            $table->string('filename')->nullable();
            $table->string('original_filename')->nullable();
            $table->integer('filesize')->nullable();
            $table->integer('thumbnail_filesize')->nullable();
            $table->text('url')->nullable();

            $table->integer("organisation_id")->unsigned()->nullable();

            $table->bigInteger('membership_id')->nullable();
            $table->string('membership_type')->nullable();

            $table->boolean('activer')->default(1);
            $table->boolean('desactiver')->default(0);
            $table->boolean('blocked')->default(0);

            $table->text('thumbnail_url')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->foreign('organisation_id')->references('id')->on("users")->onDelete("cascade");
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
        Schema::dropIfExists('users');
    }
}
