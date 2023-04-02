<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelayanan extends Model
{
    use HasFactory;

    protected $table = 'pelayanan';
    protected $fillable = [
        'kode_pelayanan',
        'user_id',
        'dokter_id',
        'layanan',
        'paket',
        'alamat',
        'kota_id',
        'riwayat_penyakit',
        'no_telepon',
        'waktu_mulai',
        'waktu_selesai',
        'harga',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pasien_id', 'id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id', 'id');
    }
}
