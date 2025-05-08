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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->string('img', 255)->nullable();
            $table->unsignedBigInteger('track_id')->nullable();
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->unsignedBigInteger('performer_id');
            $table->foreign('performer_id')->references('id')->on('users');
            $table->integer('likes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
