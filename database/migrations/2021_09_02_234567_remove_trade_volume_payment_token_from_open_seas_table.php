<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTradeVolumePaymentTokenFromOpenSeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('open_seas', function (Blueprint $table) {
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
            $table->unsignedBigInteger('total_volume_payment_token')->after('total_volume_usd');
        });       
    }
}
