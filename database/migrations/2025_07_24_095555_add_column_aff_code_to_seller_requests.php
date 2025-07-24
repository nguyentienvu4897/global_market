<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnAffCodeToSellerRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->string('aff_code')->nullable()->after('campaign_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('aff_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->dropColumn('aff_code');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('aff_code');
        });
    }
}
