<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collection_colors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_set_id')->unsigned();
            $table->bigInteger('color_id')->unsigned();
            $table->foreign('product_set_id')->references('id')->on('product_sets')->onDelete('cascade');
            $table->foreign('color_id')->references('id')->on('attribute_options')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_colors');
    }
}
