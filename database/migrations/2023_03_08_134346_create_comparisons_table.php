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
        Schema::create('comparisons', function (Blueprint $table) {
            $table->id();

            $table->integer('sorting')->default(0);

            $table->bigInteger('price')->default(0);

            $table->boolean('featured')->default(true);
            $table->boolean('status')->default(true);

            $table->string('image')->nullable();
            $table->json('slide')->nullable();

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text("content")->nullable();

            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();

            $table->unsignedBigInteger('product_category_id');

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
        Schema::dropIfExists('comparisons');
    }
};
