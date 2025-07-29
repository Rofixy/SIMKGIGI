<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anamnesa extends Model
{
    protected $table = 'anamnesa';

    protected $fillable = [
        'janji_id', 'keluhan', 'pemeriksaan', 'diagnosa', 'tindakan'
    ];

    public function janji()
    {
        return $this->belongsTo(Janji::class);
    }
}
