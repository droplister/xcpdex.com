<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTradePricePaymentTokenToOpenSeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('open_seas', function (Blueprint $table) {
            $table->string('trade_price_payment_token')->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('open_seas', function (Blueprint $table) {
            $table->dropColumn('trade_price_payment_token')->nullable()->after('quantity');
        });       
    }
}
