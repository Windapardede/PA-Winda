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
        Schema::create('testimoni', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->index('testimonials_user_id_fkey');
            $table->integer('mentor_id');
            $table->text('content');
            $table->dateTime('created_at', 3)->useCurrent();
            $table->dateTime('updated_at', 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimoni');
    }
};
