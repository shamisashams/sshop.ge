<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAddSocialite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {

            $table->bigInteger('facebook_id')->nullable();
            $table->string('facebook_token',300)->nullable();
            $table->string('facebook_refresh_token',300)->nullable();
            $table->string('facebook_avatar')->nullable();

            $table->string('avatar')->nullable();

            $table->bigInteger('google_id')->nullable();
            $table->string('google_token',300)->nullable();
            $table->string('google_refresh_token',300)->nullable();
            $table->string('google_avatar')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //

            $table->dropColumn('facebook_id');
            $table->dropColumn('facebook_token');
            $table->dropColumn('facebook_refresh_token');
            $table->dropColumn('facebook_avatar');

            $table->dropColumn('avatar');

            $table->dropColumn('google_id');
            $table->dropColumn('google_token');
            $table->dropColumn('google_refresh_token');
            $table->dropColumn('google_avatar');

        });
    }
}
