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
        Schema::table('color', function (Blueprint $table) {
            $table->foreign(['product_id'], 'color_ibfk_1')->references(['Id'])->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('color', function (Blueprint $table) {
            $table->dropForeign('color_ibfk_1');
        });
    }
};
