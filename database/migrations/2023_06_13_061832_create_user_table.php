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
        Schema::create('user', function (Blueprint $table) {
            $table->integer('Id', true);
            $table->string('name', 50);
            $table->mediumText('email');
            $table->string('provider', 45)->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('access_token', 405)->nullable();
            $table->string('session_token', 405)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
};
