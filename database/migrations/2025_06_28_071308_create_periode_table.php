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
        Schema::create('periode', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('periode_user_id_fkey');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_selesai');
            $table->dateTime('created_at', 3)->useCurrent();
            $table->dateTime('updated_at', 3);
            $table->boolean('is_active')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode');
    }
};
