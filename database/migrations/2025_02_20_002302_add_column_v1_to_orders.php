<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnV1ToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('type')->after('id')->default(0);
            $table->dateTime('aff_order_at')->nullable();
            $table->string('aff_merchant')->nullable();
            $table->decimal('aff_total_revenue', 16, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('aff_order_at');
            $table->dropColumn('aff_merchant');
            $table->dropColumn('aff_total_revenue');
        });
    }
}
