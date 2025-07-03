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
        Schema::create('posisi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100)->nullable();
            $table->integer('total_kuota')->nullable();
            $table->integer('kuota_tersedia')->nullable();
            $table->text('persyaratan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->enum('status', ['publish', 'unpublish'])->default('publish');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posisi');
    }
};
