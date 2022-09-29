<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSetTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_set_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('product_set_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keyword')->nullable();

            $table->unique(['product_set_id','locale']);
            $table->foreign('product_set_id')
                ->references('id')
                ->on('product_sets')
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
        Schema::dropIfExists('product_set_translations');
    }
}
