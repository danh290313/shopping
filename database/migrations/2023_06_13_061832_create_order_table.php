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
        Schema::create('order', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->boolean('paid')->nullable()->default(false);
            $table->text('note')->nullable();
            $table->tinyInteger('status');
            $table->integer('user_id')->nullable()->index('customer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};
