<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Kunjungan;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'no_transaksi';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'no_transaksi',
        'id_pasien',
        'id_kunjungan',
        'total_bayar',
        'tanggal',
        'metode_pembayaran',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'id_kunjungan');
    }
}
