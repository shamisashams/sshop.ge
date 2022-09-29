<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSettinsAddValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('settings', function (Blueprint $table) {

            $table->float('float_value')->nullable();
            $table->integer('integer_value')->nullable();
            $table->string('string_value')->nullable();
            $table->json('json_value')->nullable();

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
        Schema::table('settings', function (Blueprint $table) {

            $table->dropColumn('float_value');
            $table->dropColumn('integer_value');
            $table->dropColumn('string_value');
            $table->dropColumn('json_value');


        });
    }
}
