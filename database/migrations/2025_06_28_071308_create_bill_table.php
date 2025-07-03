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
        Schema::create('bill', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('status_bill')->nullable();
            $table->timestamp('time_order')->useCurrentOnUpdate()->useCurrent();
            $table->integer('queque_session_id');
            $table->integer('id_user');
            $table->string('note')->nullable();
            $table->double('total');
            $table->json('details')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill');
    }
};
