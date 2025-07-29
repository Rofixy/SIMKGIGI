<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';

    protected $fillable = [
        'user_id', 'spesialisasi', 'jadwal_praktik', 'telepon'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function janji()
    {
        return $this->hasMany(Janji::class);
    }

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }

}
