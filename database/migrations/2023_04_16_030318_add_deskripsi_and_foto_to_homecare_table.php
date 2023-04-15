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
        Schema::table('homecare', function (Blueprint $table) {
            $table->text('deskripsi')->after('poli_id');
            $table->string('foto')->default('default.png')->after('deskripsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homecare', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->dropColumn('foto');
        });
    }
};
