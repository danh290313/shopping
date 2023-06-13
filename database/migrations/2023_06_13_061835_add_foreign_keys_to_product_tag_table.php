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
        Schema::table('product_tag', function (Blueprint $table) {
            $table->foreign(['product_id'], 'product_tag_ibfk_1')->references(['Id'])->on('product');
            $table->foreign(['tag_id'], 'product_tag_ibfk_2')->references(['Id'])->on('tag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_tag', function (Blueprint $table) {
            $table->dropForeign('product_tag_ibfk_1');
            $table->dropForeign('product_tag_ibfk_2');
        });
    }
};
