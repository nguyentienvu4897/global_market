<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnV1ToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('origin')->nullable()->comment('Nguồn sản phẩm');
            $table->text('origin_link')->nullable()->comment('Link nguồn sản phẩm');
            $table->text('aff_link')->nullable()->comment('Link affiliate');
            $table->text('short_link')->nullable()->comment('Link rút gọn');
            $table->string('person_in_charge')->nullable()->comment('Người phụ trách');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('origin');
            $table->dropColumn('origin_link');
            $table->dropColumn('aff_link');
            $table->dropColumn('short_link');
            $table->dropColumn('person_in_charge');
        });
    }
}
