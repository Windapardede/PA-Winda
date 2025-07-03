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
        Schema::create('pinjam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_buku')->index('pinjam_id_buku_foreign');
            $table->unsignedBigInteger('id_user')->index('pinjam_id_user_foreign');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_pengembalian')->nullable();
            $table->string('status_peminjaman', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjam');
    }
};
