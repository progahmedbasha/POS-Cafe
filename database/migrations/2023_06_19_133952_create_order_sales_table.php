<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_number')->unsigned();
            $table->unsignedInteger('product_id')->unsigned();
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedInteger('price');
            $table->unsignedInteger('total_cost');
            $table->string('note', 50)->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_sales');
    }
};