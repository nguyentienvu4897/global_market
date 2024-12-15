<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettlementDateComumnToOrderRevenueDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_revenue_details', function (Blueprint $table) {
            $table->dateTime('settlement_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_revenue_details', function (Blueprint $table) {
            $table->dropColumn('settlement_date');
        });
    }
}
