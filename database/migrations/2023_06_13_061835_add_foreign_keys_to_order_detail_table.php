<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_detail_ibfk_1')->references(['id'])->on('order');
            $table->foreign(['product_detail_id'], 'order_detail_ibfk_2')->references(['id'])->on('product_detail');
            $table->foreign(['review_id'], 'order_detail_ibfk_3')->references(['Id'])->on('review');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_detail', function (Blueprint $table) {
            $table->dropForeign('order_detail_ibfk_1');
            $table->dropForeign('order_detail_ibfk_2');
            $table->dropForeign('order_detail_ibfk_3');
        });
    }
};
