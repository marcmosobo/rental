<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('location')->nullable();
            $table->string('property_type')->nullable();
            $table->integer('units')->nullable();
            $table->double('commission')->nullable();
            $table->integer('month_billing_day')->default(5);
            $table->bigInteger('landlord_id')->unsigned()->nullable();
            $table->foreign('landlord_id')->references('id')->on('masterfiles')->onUpdate('cascade')->onDelete('no action');
            $table->integer('created_by')->index()->nullable();
            $table->integer('client_id')->nullable()->index();
            $table->boolean('status')->default(true);
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
        Schema::dropIfExists('properties');
    }
}
