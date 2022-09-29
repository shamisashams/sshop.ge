<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('stock_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->string('address')->nullable();

            $table->unique(['stock_id','locale']);
            $table->foreign('stock_id')
                ->references('id')
                ->on('stocks')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_translations');
    }
}
