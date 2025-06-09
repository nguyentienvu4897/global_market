<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaignIdColumnToSellerRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seller_requests', function (Blueprint $table) {
            $table->unsignedInteger('campaign_id')->after('use_account_client')->nullable();
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
            $table->dropColumn('campaign_id');
        });
    }
}
