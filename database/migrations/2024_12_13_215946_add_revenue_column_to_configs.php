<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRevenueColumnToConfigs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->decimal('revenue_percent_5', 10, 2)->default(0);
            $table->decimal('revenue_percent_4', 10, 2)->default(0);
            $table->decimal('revenue_percent_3', 10, 2)->default(0);
            $table->decimal('revenue_percent_2', 10, 2)->default(0);
            $table->decimal('revenue_percent_1', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('revenue_percent_5');
            $table->dropColumn('revenue_percent_4');
            $table->dropColumn('revenue_percent_3');
            $table->dropColumn('revenue_percent_2');
            $table->dropColumn('revenue_percent_1');
        });
    }
}
