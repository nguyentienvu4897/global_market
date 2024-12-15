<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRevenueDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_revenue_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('order_code');
            $table->unsignedBigInteger('user_id');
            $table->string('user_email')->nullable();
            $table->unsignedTinyInteger('user_level')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->decimal('revenue_percent', 10, 2)->default(0);
            $table->decimal('revenue_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_revenue_details');
    }
}
