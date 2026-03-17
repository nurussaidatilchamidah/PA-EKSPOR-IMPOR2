<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEksporImpor extends Model
{
    protected $table = 'data_ekspor_impors'; // pastikan sesuai nama tabel di database

protected $fillable = [
    'tanggal',
    'nilai_ekspor',
    'berat_ekspor',
    'nilai_impor',
    'berat_impor',
];

}
