<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();

            $table->boolean('status')->default(true);
            $table->boolean('recommended')->default(true);
            $table->boolean('featured')->default(true);

            $table->string('image')->nullable();
            $table->string('banner')->nullable();
            $table->string('icon')->nullable();

            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('url')->nullable();

            $table->integer('sorting')->default(0);

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
        Schema::dropIfExists('sellers');
    }
};
