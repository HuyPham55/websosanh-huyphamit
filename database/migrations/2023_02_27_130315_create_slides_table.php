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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();

            $table->string('key');
            $table->unsignedInteger('sorting')->default(0);
            $table->boolean('status')->default(true);

            $table->json('image')->nullable();
            $table->json('url')->nullable();
            $table->json('text_1')->nullable();
            $table->json('text_2')->nullable();
            $table->json('text_3')->nullable();
            $table->json('description')->nullable();

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
        Schema::dropIfExists('slides');
    }
};
