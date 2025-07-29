<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Janji extends Model
{
    use HasFactory;

    protected $table = 'janji';

    protected $fillable = [
        'pasien_id', 'dokter_id', 'jadwal'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    public function anamnesa()
    {
        return $this->hasOne(Anamnesa::class);
    }
}
