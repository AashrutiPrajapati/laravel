<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCartaddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cartaddress', function (Blueprint $table) {
            $table->string('address')->nullable()->default(null)->change();
            $table->string('city')->nullable()->default(null)->change();
            $table->string('state')->nullable()->default(null)->change();
            $table->string('country')->nullable()->default(null)->change();
            $table->string('zipcode')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartaddress', function (Blueprint $table) {
            //
        });
    }
}
