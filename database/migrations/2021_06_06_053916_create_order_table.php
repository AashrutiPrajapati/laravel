<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customerId')->unsigned();
            $table->string('total')->default(0);
            $table->string('discount')->default(0);
            $table->bigInteger('paymentMethodId')->unsigned()->default(1);
            $table->bigInteger('shippingMethodId')->unsigned()->default(1);
            $table->string('shippingAmount')->default(0);
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
        Schema::dropIfExists('order');
    }
}
