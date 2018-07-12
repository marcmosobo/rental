<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandlordRemmitanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlord_remittances', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('landlord_id')->unsigned();
            $table->foreign('landlord_id')->references('id')->on('masterfiles');
            $table->double('amount');
            $table->integer('remitted_by')->nullable();
            $table->dateTime('date');
            $table->softDeletes();
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
        Schema::dropIfExists('landlord_remmitance');
    }
}
