<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductSetsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('product_sets', function (Blueprint $table) {

            $table->float('special_price')->nullable();
            $table->string('code')->nullable();

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
        Schema::table('product_sets', function (Blueprint $table) {

            $table->dropColumn('special_price');
            $table->dropColumn('code');
        });
    }
}
