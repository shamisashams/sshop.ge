<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCartItemsRemovePrimary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('cart_items', function (Blueprint $table) {

            //$table->dropPrimary('id');
            $table->dropColumn('id');
            $table->primary(['cart_id','product_id']);



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
        Schema::table('cart_items', function (Blueprint $table) {

            $table->dropPrimary(['cart_id','product_id']);
            $table->id();


        });
    }
}
