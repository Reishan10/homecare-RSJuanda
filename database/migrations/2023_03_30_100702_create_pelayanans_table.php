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
        Schema::create('pelayanan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pelayanan');
            $table->uuid('pasien_id')->nullable();
            $table->uuid('dokter_id')->nullable();
            $table->string('layanan');
            $table->string('paket');
            $table->text('alamat');
            $table->unsignedBigInteger('kota_id');
            $table->foreign('kota_id')->references('id')->on('kota')->onDelete('cascade');
            $table->text('riwayat_penyakit')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_selesai');
            $table->string('harga', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelayanan');
    }
};
