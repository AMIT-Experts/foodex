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
        Schema::create('orderds', function (Blueprint $table) {
            $table->id();
            $table->integer('food_id');
            $table->string('quantity');
            $table->integer('day');
            $table->integer('month');
            $table->integer('year');
            $table->string('time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderds');
    }
};
