<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $table = 'obat';

    protected $primaryKey = 'kd_obat';
    public $incrementing = false; // karena bukan auto-increment

    protected $fillable = [
        'kd_obat', 'nm_obat', 'jml_obat', 'hrg_obat'
    ];
}
