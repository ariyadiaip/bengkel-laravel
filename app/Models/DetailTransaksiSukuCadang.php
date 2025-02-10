<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiSukuCadang extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_suku_cadang';
    protected $primaryKey = 'id_detail_suku_cadnag';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'qty', 
        'diskon', 
        'harga_setelah_diskon', 
        'id_transaksi', 
        'id_suku_cadang'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function sukuCadang()
    {
        return $this->belongsTo(SukuCadang::class, 'id_suku_cadang');
    }
}
