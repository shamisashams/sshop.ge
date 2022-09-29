<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductProductSetsChangeCoord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('product_product_sets', function (Blueprint $table) {

            $table->string('coordinates')->default('auto auto auto auto')->nullable()->change();

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
        Schema::table('product_product_sets', function (Blueprint $table) {

            $table->string('coordinates')->nullable();

        });
    }
}
