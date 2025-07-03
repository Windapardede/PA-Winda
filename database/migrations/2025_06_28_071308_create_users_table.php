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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->string('phone')->nullable();
            $table->integer('posisi_id')->nullable();
            $table->integer('instansi_id')->nullable();
            $table->integer('jurusan_id')->nullable();
            $table->integer('roles_id')->nullable();
            $table->enum('role', ['admin', 'hrd', 'mentor', 'user']);
            $table->integer('mentor_id')->nullable();
            $table->text('image')->nullable();
            $table->string('nim', 100)->nullable();
            $table->string('religion', 191)->nullable();
            $table->boolean('is_active')->nullable();
            $table->enum('status', ['proses', 'lulus', 'tes_kema...'])->nullable();
            $table->string('gender', 100)->nullable();
            $table->string('surat', 100)->nullable();
            $table->string('cv', 191)->nullable();
            $table->date('mulai_magang')->nullable();
            $table->date('selesai_magang')->nullable();
            $table->integer('otp')->nullable();
            $table->enum('status_otp', ['1', '2'])->nullable()->default('1');
            $table->string('position', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
