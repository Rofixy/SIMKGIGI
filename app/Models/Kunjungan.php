<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kunjungan extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $primaryKey = 'id_kunjungan';
    public $incrementing = false;

    protected $fillable = [
        'id_kunjungan',
        'id_pasien',
        'id_dokter',
        'tgl_kunjungan',
        'jam_kunjungan',
        'keluhan',
        'keterangan',
    ];

    public function pasien()
    {
        return $this->belongsTo(User::class, 'id_pasien');
    }

    public function dokter()
    {
        return $this->belongsTo(User::class, 'id_dokter');
    }
}
