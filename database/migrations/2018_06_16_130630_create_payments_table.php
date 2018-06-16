<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('payment_mode');
            $table->string('house_number')->nullable()->index();
            $table->bigInteger('tenant_id')->index()->nullable();
            $table->string('ref_number')->nullable();
            $table->double('amount');
            $table->string('paybill')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('BillRefNumber')->nullable();
            $table->string('TransID')->nullable();
            $table->timestamp('TransTime')->nullable();
            $table->string('FirstName')->nullable();
            $table->string('middleName')->nullable();
            $table->string('LastName')->nullable();
            $table->dateTime('received_on')->nullable();
            $table->integer('client_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('payments');
    }
}
