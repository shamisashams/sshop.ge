<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageSectionTranslations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_section_translations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('page_section_id')->unsigned();
            $table->string('locale')->index();

            $table->string('title')->nullable();
            $table->text('text')->nullable();

            $table->unique(['page_section_id','locale']);
            $table->foreign('page_section_id')
                ->references('id')
                ->on('page_sections')
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
        Schema::dropIfExists('page_section_translations');
    }
}
