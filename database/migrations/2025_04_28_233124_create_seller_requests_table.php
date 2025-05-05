<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('use_account_client')->default(0);
            $table->string('shop_name');
            $table->string('email');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('account_name')->nullable();
            $table->string('password')->nullable();
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();

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
        Schema::dropIfExists('seller_requests');
    }
}
