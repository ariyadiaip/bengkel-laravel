<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiJasa extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi_jasa';
    protected $primaryKey = 'id_detail_jasa';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'qty', 
        'diskon', 
        'harga_setelah_diskon', 
        'id_transaksi', 
        'id_jasa'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }
}
