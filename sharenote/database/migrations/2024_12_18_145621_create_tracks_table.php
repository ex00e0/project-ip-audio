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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70);
            $table->unsignedBigInteger('performer_id');
            $table->foreign('performer_id')->references('id')->on('users');
            $table->string('file', 255);
            $table->unsignedBigInteger('album_id');
            $table->foreign('album_id')->references('id')->on('albums');
            $table->enum('genre', ['классика', 'джаз', 'рок', 'поп', 'хип-хоп', 'электронная музыка', 'другое']);
            $table->integer('count_l')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
