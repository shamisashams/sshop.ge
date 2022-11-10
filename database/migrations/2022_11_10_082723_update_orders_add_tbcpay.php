<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersAddTbcpay extends Migration
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

            $table->string('tbc_pay_id')->nullable();
            $table->string('tbc_transaction_id')->nullable();
            $table->string('tbc_rec_id')->nullable();
            $table->integer('tbc_payment_method')->nullable();
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

            $table->dropColumn('tbc_pay_id');
            $table->dropColumn('tbc_transaction_id');
            $table->dropColumn('tbc_rec_id');
            $table->dropColumn('tbc_payment_method');

        });
    }
}
