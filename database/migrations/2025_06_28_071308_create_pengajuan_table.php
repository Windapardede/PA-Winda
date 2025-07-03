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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('pengajuan_user_id_fkey');
            $table->integer('posisi_id')->nullable()->index('pengajuan_posisi_id_fkey');
            $table->integer('periode_id')->nullable()->index('pengajuan_periode_id_fkey');
            $table->integer('soal_id')->nullable();
            $table->boolean('is_active')->nullable();
            $table->enum('status_administrasi', ['belumDiproses', 'diterima', 'proses', 'ditolak'])->nullable()->default('belumDiproses');
            $table->enum('status_tes_kemampuan', ['belumDiproses', 'diterima', 'proses', 'ditolak'])->nullable()->default('belumDiproses');
            $table->enum('status_wawancara', ['belumDiproses', 'diterima', 'proses', 'ditolak'])->nullable()->default('belumDiproses');
            $table->enum('status', ['belumDiproses', 'proses', 'alumni', 'tes_kemampuan', 'ditolak', 'administrasi', 'wawancara', 'diterima'])->nullable()->default('belumDiproses');
            $table->date('tanggal_wawancara')->nullable();
            $table->time('jam_wawancara')->nullable();
            $table->date('tanggal_awal_tes_kemampuan')->nullable();
            $table->date('tanggal_akhir_tes_kemampuan')->nullable();
            $table->text('link_wawancara')->nullable();
            $table->text('catatan_tolak_administrasi')->nullable();
            $table->text('catatan_tolak_tes_kemampuan')->nullable();
            $table->text('catatan_tolak_wawancara')->nullable();
            $table->text('catatan_terima_wawancara')->nullable();
            $table->dateTime('created_at', 3)->useCurrent();
            $table->dateTime('updated_at', 3);
            $table->string('jawaban_tes_kemampuan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};
