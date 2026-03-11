<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataHS extends Model
{
    protected $table = 'data_hs';

    protected $fillable = [
        'kode_hs',
        'nama_barang',
        'nilai_ekspor',
        'berat_ekspor',
        'nilai_impor',
        'berat_impor',
    ];
    protected $casts = [
    'nilai_ekspor' => 'decimal:3',
    'berat_ekspor' => 'decimal:3',
    'nilai_impor'  => 'decimal:3',
    'berat_impor'  => 'decimal:3',
];

}
