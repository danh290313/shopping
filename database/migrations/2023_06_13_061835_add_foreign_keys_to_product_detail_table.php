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
        Schema::table('product_detail', function (Blueprint $table) {
            $table->foreign(['product_id'], 'product_detail_ibfk_1')->references(['Id'])->on('product');
            $table->foreign(['picture_id'], 'product_detail_ibfk_2')->references(['Id'])->on('picture');
            $table->foreign(['color_id'], 'product_detail_ibfk_3')->references(['id'])->on('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_detail', function (Blueprint $table) {
            $table->dropForeign('product_detail_ibfk_1');
            $table->dropForeign('product_detail_ibfk_2');
            $table->dropForeign('product_detail_ibfk_3');
        });
    }
};
