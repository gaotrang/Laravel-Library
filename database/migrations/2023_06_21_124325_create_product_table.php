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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreign('product_category_id')->references('id')->on('product_category');
            $table->string('name', 255);
            $table->string('slug',255)->nullable();
            $table->float('price')->nullable()->unsigned();
            $table->float('discount_price')->nullable()->unsigned();
            $table->text('description');
            $table->text('short_description');
            $table->text('information');
            $table->integer('qty')->unsigned();
            $table->string('image_url',255);
            $table->string('shipping',255)->nullable();
            $table->float('weight')->nullable()->unsigned();
            
            $table->boolean('status')->default(1);
  
           //buoc 1: tao field
        //    $table->biginteger('product_category_id')->unsigned();
           $table->unsignedBigInteger('product_category_id');

           //Buoc2: chi dinh field do la khoa ngoai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
