<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jasa extends Model
{
    protected $table = 'jasa';
    protected $primaryKey = 'id_jasa';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'nama_jasa',
        'harga_satuan',
    ];
}
