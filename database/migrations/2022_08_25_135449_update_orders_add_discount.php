<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersAddDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('orders', function(Blueprint $table)
        {
            $table->float('discount')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->index('user_id');
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
        Schema::table('orders', function(Blueprint $table)
        {
            $table->dropColumn('discount');
            $table->dropColumn('user_id');
        });
    }
}
