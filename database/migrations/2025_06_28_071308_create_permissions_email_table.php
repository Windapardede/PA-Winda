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
        Schema::create('permissions_email', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->string('name', 100)->unique('permissions_name_key');
            $table->dateTime('createdAt', 3)->useCurrent();
            $table->dateTime('updatedAt', 3);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions_email');
    }
};
