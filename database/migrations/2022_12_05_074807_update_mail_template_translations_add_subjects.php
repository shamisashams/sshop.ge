<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMailTemplateTranslationsAddSubjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('mail_template_translations', function (Blueprint $table) {

            $table->string('verify_subject')->nullable();
            $table->string('promocode_cart_subject')->nullable();
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
        Schema::table('mail_template_translations', function (Blueprint $table) {

            $table->dropColumn('verify_subject');
            $table->dropColumn('promocode_cart_subject');
        });
    }
}
