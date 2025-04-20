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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('number')->unsigned();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->unsignedInteger('shift_id')->unsigned();
            $table->unsignedInteger('client_id')->unsigned()->nullable();
            $table->unsignedInteger('service_id')->unsigned();
            $table->unsignedSmallInteger('discount')->nullable();
            $table->unsignedSmallInteger('total_price')->default(0);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('is_printed')->nullable();
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
        Schema::dropIfExists('orders');
    }
};