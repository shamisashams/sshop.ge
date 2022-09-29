<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStocksChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('stocks', function (Blueprint $table) {


            $table->string('long')->nullable()->change();
            $table->string('lat')->nullable()->change();
            $table->json('lat_lng')->nullable();

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
        Schema::table('stocks', function (Blueprint $table) {


            $table->decimal('long',10, 7)->change();
            $table->decimal('lat',10, 7)->change();
            $table->dropColumn('lat_lng');
        });
    }
}
