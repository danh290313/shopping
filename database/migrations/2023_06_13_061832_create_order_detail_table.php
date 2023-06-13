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
        Schema::create('order_detail', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('order_id')->nullable()->index('order_id');
            $table->integer('product_detail_id')->nullable()->index('order_detail_ibfk_2');
            $table->decimal('regular_price', 15)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('review_id')->nullable()->index('review_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_detail');
    }
};
