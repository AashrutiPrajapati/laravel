<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartaddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartaddress', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cartId')->unsigned();
            $table->foreign('cartId')->references('id')->on('cart')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('addressType', ['billing', 'shipping']);
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zipcode');
            $table->string('same_as_billing')->default('0');
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
        Schema::dropIfExists('cartaddress');
    }
}
