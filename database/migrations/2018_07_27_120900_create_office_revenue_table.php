<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeRevenueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('office_revenue', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_expenditure_id')->unsigned()->nullable();
            $table->foreign('office_expenditure_id')->references('id')->on('office_expenditures')->onDelete('cascade');
            $table->string('transaction_type');
            $table->string('ref_number')->nullable();
            $table->double('amount');
            $table->date('date');
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('office_revenue');
    }
}
