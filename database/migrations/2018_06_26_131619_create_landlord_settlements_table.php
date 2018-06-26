<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLandlordSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landlord_settlements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('landlord_id')->unsigned()->index();
            $table->dateTime('date');
            $table->double('amount_collected');
            $table->double('commission_percentage');
            $table->double('commission_amount');
            $table->double('overdraft');
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
        Schema::dropIfExists('landlord_settlements');
    }
}
