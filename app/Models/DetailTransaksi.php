<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;
use App\Models\Obat;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_detail', 'no_transaksi', 'kode_obat', 'jumlah', 'subtotal'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'no_transaksi', 'no_transaksi');
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class, 'kode_obat', 'kd_obat');
    }
}
