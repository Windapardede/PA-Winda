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
        Schema::create('detail_project', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('project_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['proses', 'diterima', 'revisi'])->nullable()->default('proses');
            $table->integer('persentasi');
            $table->text('revisi')->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_project');
    }
};
