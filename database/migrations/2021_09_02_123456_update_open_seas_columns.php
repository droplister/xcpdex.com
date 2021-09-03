<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOpenSeasColumns extends Migration
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
            $table->dropColumn('total_volume_payment_token');
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
            $table->unsignedBigInteger('total_volume_payment_token')->after('total_volume_usd');
        });       
    }
}
