<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('type_id')->references('id')->on('user_types')->onUpdate('cascade');
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onUpdate('cascade');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade');
        });
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::table('order_times', function (Blueprint $table) {
             $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade');
        });
        Schema::table('shifts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
    }
};