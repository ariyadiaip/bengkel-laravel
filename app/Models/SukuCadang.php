<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SukuCadang extends Model
{
    protected $table = 'suku_cadang';
    protected $primaryKey = 'id_suku_cadang';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nama_suku_cadang',
        'harga_satuan',
    ];
}
