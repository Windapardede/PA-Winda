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
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pengajuan_id')->unique('sertifikat_mentee_pengajuan_id_key');
            $table->text('location');
            $table->dateTime('created_at', 3)->useCurrent();
            $table->dateTime('updated_at', 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
