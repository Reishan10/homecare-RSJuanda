<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $fillable = [
        'kode_rekam_medis',
        'user_id',
        'dokter_id',
        'tanggal_kunjungan',
        'keluhan',
        'diagnosa',
        'resep_obat',
        'catatan_tambahan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
}
