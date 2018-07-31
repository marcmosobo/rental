<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToLandlordRemitances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('landlord_remittances', function (Blueprint $table) {
            $table->string('payment_mode')->nullable();
            $table->integer('bank_id')->nullable();
            $table->string('ref_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('landlord_remittances', function (Blueprint $table) {
            $table->dropColumn(['payment_mode','bank_id','ref_number']);
        });
    }
}
