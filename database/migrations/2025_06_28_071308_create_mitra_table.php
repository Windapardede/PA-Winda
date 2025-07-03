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
        Schema::create('mitra', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('kuota');
            $table->integer('kuota_tersedia');
            $table->boolean('is_active');
            $table->dateTime('createdAt', 3)->useCurrent();
            $table->dateTime('updatedAt', 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
