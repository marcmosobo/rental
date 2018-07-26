<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_refunds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lease_id')->unsigned();
            $table->double('amount');
            $table->integer('refunded_by')->nullable();
            $table->dateTime('refund_date');
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
        Schema::dropIfExists('deposit_refunds');
    }
}
