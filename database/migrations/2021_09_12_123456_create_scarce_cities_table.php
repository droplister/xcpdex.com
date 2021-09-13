<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScarceCitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scarce_cities', function (Blueprint $table) {
            $table->id();
            $table->string('permalink');
            $table->string('asset')->index();
            $table->unsignedBigInteger('price_btc');
            $table->unsignedBigInteger('price_usd');
            $table->string('timestamp');
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
        Schema::dropIfExists('scarce_cities');
    }
}
