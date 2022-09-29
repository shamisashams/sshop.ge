<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableAddAttrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('products', function (Blueprint $table) {
            $table->string('size')->nullable();
            $table->string('corner')->nullable();
            $table->bigInteger('color_id')->unsigned();
            $table->bigInteger('brand_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('size');
            $table->dropColumn('corner');
            $table->dropColumn('color_id');
            $table->dropColumn('brand_id');
            $table->dropColumn('parent_id');
        });
    }
}
