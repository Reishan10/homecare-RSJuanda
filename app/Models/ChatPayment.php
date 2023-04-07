<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatPayment extends Model
{
    use HasFactory;

    protected $table = 'ch_payment';
    protected $fillable = ['user_id', 'dokter_id', 'waktu_mulai', 'waktu_selesai', 'biaya_chat', 'status', 'bukti_pembayaran'];
}
