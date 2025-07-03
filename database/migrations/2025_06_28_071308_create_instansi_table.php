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
        Schema::create('instansi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama')->nullable();
            $table->integer('kuota')->nullable();
            $table->integer('kuota_tersedia')->nullable();
            $table->boolean('is_active')->nullable()->default(true);
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instansi');
    }
};
