<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('xcp_core_base_asset')->index();
            $table->string('xcp_core_quote_asset')->index();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('last_price')->default('0.00000000');
            $table->string('last_trade_date')->default('----');
            $table->string('base_asset_supply')->default('0.00000000');
            $table->string('base_asset_display_name');
            $table->string('quote_asset_display_name');
            $table->unsignedBigInteger('market_cap')->index()->default(0);
            $table->unsignedBigInteger('volume')->index()->default(0);
            $table->unsignedBigInteger('orders_count')->index()->default(0);
            $table->unsignedBigInteger('open_orders_count')->index()->default(0);
            $table->unsignedBigInteger('order_matches_count')->index()->default(0);
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
        Schema::dropIfExists('markets');
    }
}