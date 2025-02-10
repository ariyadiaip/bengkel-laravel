<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    public $timestamps = false;

    protected $fillable = [
        'no_kuitansi',
        'no_work_order',
        'tanggal_transaksi',
        'tanggal_kembali',
        'grand_total',
        'status_pembayaran',
        'saran_mekanik',
        'id_mekanik',
        'id_kendaraan'
    ];

    // Relasi ke Mekanik
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'id_mekanik');
    }

    // Relasi ke Kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }

    public function jasa()
    {
        return $this->hasMany(DetailTransaksiJasa::class, 'id_transaksi');
    }

    public function sukuCadang()
    {
        return $this->hasMany(DetailTransaksiSukuCadang::class, 'id_transaksi');
    }
}
