<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_expenditures', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expenditure_id')->unsigned();
            $table->foreign('expenditure_id')->references('id')->on('expenditures');
            $table->integer('property_id')->unsigned()->index();
            $table->integer('landlord_id')->unsigned()->index();
            $table->integer('created_by')->index();
            $table->double('amount');
            $table->date('date');
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
        Schema::dropIfExists('property_expenditures');
    }
}
