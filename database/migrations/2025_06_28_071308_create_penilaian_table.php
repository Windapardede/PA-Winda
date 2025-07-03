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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('pengajuan_id')->nullable();
            $table->integer('mentor_id')->nullable();
            $table->string('evaluation_name', 191);
            $table->enum('evaluation_type', ['personal', 'competence']);
            $table->integer('value');
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
