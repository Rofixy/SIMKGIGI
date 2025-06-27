<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kunjungan;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis';
    protected $primaryKey = 'id_rekammedis';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_rekammedis',
        'id_kunjungan',
        'diagnosa',
        'resep_obat',
    ];

    public function kunjungan()
    {
        return $this->belongsTo(Kunjungan::class, 'id_kunjungan', 'id_kunjungan');
    }
}
