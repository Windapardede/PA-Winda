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
        Schema::table('pinjam', function (Blueprint $table) {
            $table->foreign(['id_buku'])->references(['id'])->on('buku')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['id_user'])->references(['id'])->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjam', function (Blueprint $table) {
            $table->dropForeign('pinjam_id_buku_foreign');
            $table->dropForeign('pinjam_id_user_foreign');
        });
    }
};
