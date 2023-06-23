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
        Schema::table('users',function ($table){
            $table->dropColumn('provider');
            $table->dropColumn('provider_id');
            $table->dropColumn('access_token');
            $table->dropColumn('session_token');
            $table->dropColumn('email_verified_at');
            $table->string('password')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('social_id');
            $table->string('social_provider');
            $table->string('avatar',2083)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
