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
        Schema::create('static_pages', function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->integer('sorting')->default(0);
            $table->boolean('status')->default(true);

            $table->json('image')->nullable();
            $table->json('title')->nullable();
            $table->json('slug')->nullable();
            $table->json('content')->nullable();
            $table->json('seo_title')->nullable();
            $table->json('seo_description')->nullable();

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
        Schema::dropIfExists('static_pages');
    }
};
