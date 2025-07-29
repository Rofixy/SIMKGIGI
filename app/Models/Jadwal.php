<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    // Tambahkan 'tanggal_praktik' agar bisa mass-assignment (store/update)
    protected $fillable = [
        'dokter_id',
        'tanggal_praktik',
        'hari',
        'jam_mulai',
        'jam_selesai'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function janji()
    {
        return $this->hasMany(Janji::class, 'id_jadwal');
    }
}
