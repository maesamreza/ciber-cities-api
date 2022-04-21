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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->double('price')->nullable();
            $table->double('discount_price')->nullable();
            $table->text('image')->nullable();
            $table->string('color')->nullable();
            $table->enum('size',['Small', 'Medium', 'Large', 'Xlarge'])->default('Medium');
            $table->enum('details',['Available in black, Nude, Red, Clear', '4.5 inch Gold Heel', 'Pointed Toe', 'Patent', 'Imported'])->default('4.5 inch Gold Heel');
            $table->string('brand')->nullable();
            $table->integer('selected_qty')->nullable();
            $table->string('status')->nullable();
            $table->integer('stock')->nullable();
            // $table->integer('rating')->nullable();
            // $table->text('review')->nullable();
            // $table->string('tags')->nullable();
            // $table->string('weight')->nullable();
            // $table->text('short_description')->nullable();
            // $table->text('description')->nullable();
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
        Schema::dropIfExists('products');
    }
};
