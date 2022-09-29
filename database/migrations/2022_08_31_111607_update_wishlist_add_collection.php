<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateWishlistAddCollection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('wishlist', function (Blueprint $table) {

            $table->bigInteger('product_id')->unsigned()->nullable()->change();
            $table->bigInteger('product_set_id')->unsigned()->nullable();
            $table->foreign('product_set_id')->references('id')->on('product_sets')->onDelete('cascade');

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
        Schema::table('wishlist', function (Blueprint $table) {

            $table->dropForeign('wishlist_product_set_id_foreign');
            $table->bigInteger('product_id')->unsigned()->change();
            $table->dropColumn('product_set_id');


        });
    }
}
