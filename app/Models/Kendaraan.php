<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';
    protected $primaryKey = 'id_kendaraan';
    public $timestamps = false;

    protected $fillable = [
        'no_polisi',
        'tipe',
        'model',
        'tahun',
        'id_pelanggan'
    ];

    // Relasi ke Pelanggan (Many to One)
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}
