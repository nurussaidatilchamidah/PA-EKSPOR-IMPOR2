<?php

namespace App\Services;

use App\Models\DataEksporImpor;

class InsightService
{
   public function getInsight()
{
    $data = DataEksporImpor::orderBy('tanggal')->get();

    $eksporTertinggi = $data->sortByDesc('nilai_ekspor')->first();
    $imporTertinggi = $data->sortByDesc('nilai_impor')->first();

    $totalEkspor = $data->sum('nilai_ekspor');
    $totalImpor = $data->sum('nilai_impor');

    $selisih = $totalEkspor - $totalImpor;

    // ================= TREND (%) =================
    $ekspor = $data->pluck('nilai_ekspor')->values();

    $first = $ekspor->first();
    $last = $ekspor->last();

    $growth = 0;
    if ($first > 0) {
        $growth = (($last - $first) / $first) * 100;
    }

    // ================= STATUS EKONOMI =================
    if ($selisih > 0) {
        $status = "Surplus perdagangan (ekspor lebih besar dari impor)";
    } else {
        $status = "Defisit perdagangan (impor lebih besar dari ekspor)";
    }

    // ================= ANALISIS NARASI (DEEP) =================
    $narasi = "Analisis menunjukkan bahwa selama periode pengamatan, ";

    $narasi .= "total ekspor mencapai Rp " . number_format($totalEkspor) . 
    " sedangkan total impor sebesar Rp " . number_format($totalImpor) . ". ";

    $narasi .= "Hal ini menghasilkan selisih sebesar Rp " . number_format(abs($selisih)) . 
    " yang menunjukkan kondisi " . strtolower($status) . ". ";

    if ($growth > 0) {
        $narasi .= "Selain itu, ekspor mengalami pertumbuhan sebesar " . round($growth, 2) . "% yang mengindikasikan peningkatan aktivitas perdagangan luar negeri. ";
    } elseif ($growth < 0) {
        $narasi .= "Selain itu, ekspor mengalami penurunan sebesar " . abs(round($growth, 2)) . "% yang mengindikasikan perlambatan aktivitas perdagangan luar negeri. ";
    } else {
        $narasi .= "Selain itu, ekspor relatif stabil tanpa perubahan signifikan. ";
    }

    // ================= INSIGHT POIN =================
    $points = [
        "Total ekspor: Rp " . number_format($totalEkspor),
        "Total impor: Rp " . number_format($totalImpor),
        "Selisih perdagangan: Rp " . number_format($selisih),
        "Komoditas ekspor tertinggi: " . ($eksporTertinggi->komoditas ?? '-'),
        "Komoditas impor tertinggi: " . ($imporTertinggi->komoditas ?? '-'),
        "Pertumbuhan ekspor: " . round($growth, 2) . "%",
        "Status: " . $status
    ];

    return [
        'ekspor_tertinggi' => $eksporTertinggi,
        'impor_tertinggi' => $imporTertinggi,
        'total_ekspor' => $totalEkspor,
        'total_impor' => $totalImpor,
        'selisih' => $selisih,
        'growth' => $growth,
        'status' => $status,
        'narasi' => $narasi,
        'points' => $points
    ];
}
}