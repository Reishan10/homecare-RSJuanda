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
        'perawat_id',
        'dokter_id',
        'homecare_id',
        'riwayat_penyakit',
        'waktu',
        'waktu_selesai',
        'provinsi_id',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'jarak',
        'metode_pembayaran',
        'bukti_pembayaran',
        'biaya_tambahan',
        'total_biaya',
        'deskripsi_kegiatan',
        'status'
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    public function perawat()
    {
        return $this->belongsTo(User::class, 'perawat_id');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function homecare()
    {
        return $this->belongsTo(Homecare::class, 'homecare_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'dokter_id', 'id');
    }
}
