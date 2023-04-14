<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiHomecare extends Model
{
    use HasFactory;
    protected $table = 'transaksi_homecare';
    protected $fillable = [
        'user_id',
        'dokter_id',
        'homecare_id',
        'riwayat_penyakit',
        'waktu',
        'jarak',
        'total_biaya',
        'status'
    ];
}
