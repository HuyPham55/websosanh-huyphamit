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

            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('seller_id')->nullable();

            $table->integer('sorting')->default(0);
            $table->bigInteger('price')->default(0);

            $table->unsignedBigInteger('hits')->default(0);

            $table->boolean('featured')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->boolean('status')->default(true);

            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('url')->nullable();

            $table->timestamp('date')->useCurrent();

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
