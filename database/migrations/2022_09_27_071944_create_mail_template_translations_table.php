<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailTemplateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_template_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('mail_template_id')->unsigned();
            $table->string("locale")->index();

            $table->text("promocode_cart")->nullable();
            $table->text("promocode_products")->nullable();
            $table->text("client_register")->nullable();
            $table->text("partner_register")->nullable();


            $table->unique(['mail_template_id','locale']);
            $table->foreign('mail_template_id')
                ->references('id')
                ->on('mail_templates')
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
        Schema::dropIfExists('mail_template_translations');
    }
}
