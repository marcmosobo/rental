<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('unit_id')->unsigned();
            $table->integer('property_id')->nullable();
            $table->foreign('unit_id')->references('id')->on('property_units')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('masterfiles')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('start_date');
            $table->boolean('status')->default(true);
            $table->integer('created_by')->nullable();
            $table->integer('client_id')->nullable();
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
        Schema::dropIfExists('leases');
    }
}
