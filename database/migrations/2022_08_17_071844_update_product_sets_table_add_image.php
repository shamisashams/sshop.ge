<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductSetsTableAddImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('product_sets', function(Blueprint $table)
        {
            $table->string('set_image')->nullable();
            $table->bigInteger('color_id')->unsigned();
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
        Schema::table('product_sets', function(Blueprint $table)
        {
            $table->dropColumn('set_image');
            $table->dropColumn('color_id');
        });
    }
}
