<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mekanik extends Model
{
    protected $table = 'mekanik';
    protected $primaryKey = 'id_mekanik';
    public $timestamps = false;
    
    protected $fillable = [
        'nama_mekanik',
        'npwp',
        'no_telepon',
    ];
}
