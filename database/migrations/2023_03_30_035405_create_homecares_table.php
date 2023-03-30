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
        Schema::create('homecare', function (Blueprint $table) {
            $table->id();
            $table->uuid('user_id')->nullable();
            $table->string('layanan');
            $table->string('paket');
            $table->text('alamat');
            $table->text('riwayat_penyakit')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('total', 100)->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homecare');
    }
};
