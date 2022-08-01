<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('organisation_id')->unsigned();
            $table->foreign('organisation_id')->references('id')->on('organisations')->onDelete("cascade");
            $table->text('others')->nullable();
            $table->text('observation')->nullable();
            $table->string('num_quit');
            $table->string('desi');
            $table->integer('unite');
            $table->double('somme_due');
            $table->date('date_fac');
            $table->double('avence');
            $table->double('reste');
            $table->date('date_pai');
            $table->date('date_del');
            $table->bigInteger('invoiceStatusId')->unsigned();
            $table->foreign('invoiceStatusId')->references('id')->on('invoicestatuses')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('typeSchargeId')->unsigned();
            $table->foreign('typeSchargeId')->references('id')->on('typescharges')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->boolean('archive')->default(0);
            $table->boolean('isPayed')->default(0);
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
        Schema::dropIfExists('charges');
    }
}
