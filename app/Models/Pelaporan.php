<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporan';
    protected $primaryKey = 'id_laporan';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_laporan', 'id_admin', 'tipe_laporan', 'id_referensi', 'tanggal_laporan', 'catatan'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}
