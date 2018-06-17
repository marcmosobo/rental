<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('masterfiles')->onDelete('cascade');
            $table->integer('lease_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->integer('bill_id')->nullable();
            $table->integer('payment_id')->nullable();
            $table->string('ref_number')->nullable();
            $table->string('transaction_type');
            $table->double('balance')->nullable();
//            $table->integer('service_bill_id')->nullable();
            $table->double('amount');
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
        Schema::dropIfExists('customer_accounts');
    }
}
