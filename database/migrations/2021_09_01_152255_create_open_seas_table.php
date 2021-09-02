<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOpenSeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_seas', function (Blueprint $table) {
            $table->id();
            $table->string('tx_hash')->unique();
            $table->string('permalink');
            $table->string('asset')->index();
            $table->string('image')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('trade_price_usd')->index();
            $table->unsignedBigInteger('total_volume_usd');
            $table->unsignedBigInteger('total_volume_payment_token');
            $table->string('seller_name')->nullable();
            $table->string('seller_address');
            $table->string('winner_name')->nullable();
            $table->string('winner_address');
            $table->string('payment_token');
            $table->unsignedInteger('payment_token_decimals');
            $table->unsignedBigInteger('payment_token_eth_price');
            $table->unsignedBigInteger('payment_token_usd_price');
            $table->timestamp('confirmed_at')->nullable()->index();
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
        Schema::dropIfExists('open_seas');
    }
}
