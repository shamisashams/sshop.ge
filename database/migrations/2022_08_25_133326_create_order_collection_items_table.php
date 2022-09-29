<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCollectionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_collection_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_collections_id')->unsigned();
            $table->foreign('order_collections_id')->references('id')->on('order_collections')->onDelete('cascade');
            $table->bigInteger('product_id')->unsigned();
            $table->string('title')->nullable();
            $table->decimal('price')->default(0);
            $table->json('attributes')->nullable();
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
        Schema::dropIfExists('order_collection_items');
    }
}
