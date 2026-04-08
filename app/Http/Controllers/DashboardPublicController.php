<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEksporImpor;
use Carbon\Carbon;
class DashboardPublicController extends Controller
{
public function index()
{
    // ambil data urut berdasarkan tanggal
    $data = DataEksporImpor::orderBy('tanggal')->get();

    // ambil kolom
    $bulan = $data->pluck('tanggal')->map(function($item){
        return Carbon::parse($item)->format('M Y');
    });
    $ekspor = $data->pluck('nilai_ekspor');
    $impor = $data->pluck('nilai_impor');

    // hitung total
    $total_ekspor = $ekspor->sum();
    $total_impor = $impor->sum();
    $selisih = $total_ekspor - $total_impor;


    return view('dashboard-public', [
        'bulan' => $bulan,
        'data_ekspor' => $ekspor,
        'data_impor' => $impor,
        'total_ekspor' => $total_ekspor,
        'total_impor' => $total_impor,
        'selisih' => $selisih
    ]);
}
}