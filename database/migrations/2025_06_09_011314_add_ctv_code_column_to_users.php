<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCtvCodeColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('ctv_code')->after('email')->nullable()->unique()->comment('Mã của ctv');
            $table->unsignedInteger('ctv_payment_date')->after('ctv_code')->nullable()->comment('Ngày thanh toán công nợ hàng tháng');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ctv_code');
            $table->dropColumn('ctv_payment_date');
        });
    }
}
