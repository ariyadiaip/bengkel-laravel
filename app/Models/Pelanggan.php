<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $timestamps = false;

    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'no_telepon'
    ];

    // Relasi ke Kendaraan (One to Many)
    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_pelanggan');
    }
}
