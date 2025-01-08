<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSettlementAmountColumnToOrderRevenueDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_revenue_details', function (Blueprint $table) {
            $table->decimal('settlement_amount', 10, 2)->default(0)->after('revenue_amount');
            $table->decimal('remaining_amount', 10, 2)->default(0)->after('settlement_amount');
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
            $table->dropColumn('settlement_amount');
            $table->dropColumn('remaining_amount');
        });
    }
}
