<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsChangeColumns extends Migration
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
            $table->float('price')->nullable()->change();
            $table->string('code')->nullable()->change();
            $table->float('installment_price')->nullable();
            $table->boolean('stock')->nullable()->change();
            $table->boolean('popular')->nullable()->change();
            $table->bigInteger('color_id')->unsigned()->nullable()->change();
            $table->bigInteger('brand_id')->unsigned()->nullable()->change();
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
            $table->float('price')->change();
            $table->string('code')->change();
            $table->dropColumn('installment_price');
            $table->boolean('stock')->change();
            $table->boolean('popular')->change();
            $table->bigInteger('color_id')->unsigned()->change();
            $table->bigInteger('brand_id')->unsigned()->change();
        });
    }
}
