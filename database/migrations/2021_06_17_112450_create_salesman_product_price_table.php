<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesmanProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesman_product_price', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salesmanId')->unsigned();
            $table->unsignedBigInteger('productId')->unsigned();
            $table->foreign('salesmanId')->references('id')->on('salesman')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('productId')->references('id')->on('salesman_product')->onDelete('cascade')->onUpdate('cascade');
            $table->string('price');
            $table->string('discount')->default(0);
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
        Schema::dropIfExists('salesman_product_price');
    }
}
