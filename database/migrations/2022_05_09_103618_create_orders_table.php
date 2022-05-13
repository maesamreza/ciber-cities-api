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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name', 40)->nullable();
            $table->string('email', 40)->nullable();
            $table->string('phone')->nullable();
            $table->string('area', 40)->nullable();
            $table->string('city', 40)->nullable();
            $table->string('delivery_address', 255)->nullable();
            $table->date('order_date')->nullable();
            $table->float('gross_amount')->nullable();
            $table->float('tax_amount')->nullable();
            $table->float('discount')->nullable();
            $table->float('net_amount')->nullable();
            $table->enum('status', ['pending', 'delivered'])->default('pending');
            $table->string('note')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('orders');
    }
};
