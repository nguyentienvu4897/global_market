<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUrlGeneratedColumnToAffiliateLinkRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('affiliate_link_requests', function (Blueprint $table) {
            $table->text('url_generated')->after('url_origin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('affiliate_link_requests', function (Blueprint $table) {
            $table->dropColumn('url_generated');
        });
    }
}
