<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('orders', function (Blueprint $table) {


            $table->text('info')->nullable()->change();
            $table->string('last_name')->nullable()->change();
            $table->string('first_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->boolean('courier_service')->nullable()->change();
            $table->string('locale')->nullable()->change();
            $table->string('city')->nullable()->change();
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
        Schema::table('orders', function (Blueprint $table) {


            $table->mediumText('info')->change();
            $table->string('last_name')->change();
            $table->string('first_name')->change();
            $table->string('phone')->change();
            $table->mediumText('address')->change();
            $table->boolean('courier_service')->change();
            $table->string('locale')->change();
            $table->string('city')->change();
        });
    }
}
