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
        Schema::create('kriteria_penilaian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('posisi_id')->nullable()->index('evaluation_criteria_templates_position_id_fkey');
            $table->string('evaluation_name', 191)->nullable();
            $table->enum('evaluation_type', ['personal', 'competence'])->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kriteria_penilaian');
    }
};
