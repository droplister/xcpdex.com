<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGiveOrdersCountToMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->unsignedBigInteger('get_orders_count')->after('orders_count')->index()->default(0);
            $table->unsignedBigInteger('give_orders_count')->after('get_orders_count')->index()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn('get_orders_count');
            $table->dropColumn('give_orders_count');
        });
    }
}
