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
        Schema::create('transaksi_homecare', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('dokter_id');
            $table->foreign('dokter_id')->references('id')->on('dokter')->onDelete('cascade');
            $table->uuid('perawat_id');
            $table->foreign('perawat_id')->references('id')->on('perawat')->onDelete('cascade');
            $table->unsignedBigInteger('homecare_id');
            $table->foreign('homecare_id')->references('id')->on('homecare')->onDelete('cascade');
            $table->string('riwayat_penyakit');
            $table->dateTime('waktu');
            $table->integer('jarak')->default(0);
            $table->string('total_biaya', 100);
            $table->tinyInteger('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_homecare');
    }
};
