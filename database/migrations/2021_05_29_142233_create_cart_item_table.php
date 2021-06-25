<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_item', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cartId')->unsigned();
            $table->foreign('cartId')->references('id')->on('cart')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('productId')->unsigned();
            $table->foreign('productId')->references('id')->on('product')->onDelete('cascade')->onUpdate('cascade');
            $table->string('quantity')->default(1);
            $table->string('basePrice');
            $table->string('price');
            $table->string('discount');
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
        Schema::dropIfExists('cart_item');
    }
}
