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

    $totalPerdagangan = $totalEkspor + $totalImpor;

    $selisih = $totalEkspor - $totalImpor;

    // ================= RATIO & DOMINASI =================
$ratio = $totalImpor > 0 ? $totalEkspor / $totalImpor : 0;
$persenLebih = ($ratio - 1) * 100;

    $dominasi = $totalEkspor > $totalImpor
        ? "Ekspor Dominan"
        : "Impor Dominan";

    $kontribusiEkspor = $totalPerdagangan > 0
        ? ($totalEkspor / $totalPerdagangan) * 100
        : 0;

        if ($kontribusiEkspor > 55) {
    $interpretasiEkspor = "Ekspor sangat dominan dalam struktur perdagangan.";
} elseif ($kontribusiEkspor > 45) {
    $interpretasiEkspor = "Ekspor dan impor relatif seimbang.";
} else {
    $interpretasiEkspor = "Impor lebih dominan dalam struktur perdagangan.";
}

    $kontribusiImpor = $totalPerdagangan > 0
        ? ($totalImpor / $totalPerdagangan) * 100
        : 0;

    // ================= TREND (%) =================
    $ekspor = $data->pluck('nilai_ekspor')->values();
    $first = $ekspor->first();
    $last = $ekspor->last();

    $growth = 0;
    if ($first > 0) {
        $growth = (($last - $first) / $first) * 100;
    }

    // ================= STATUS =================
    $status = $selisih > 0
        ? "Surplus perdagangan"
        : "Defisit perdagangan";

    // ================= FIX KOMODITAS =================
    $eksporTop = $eksporTertinggi->nama_barang
        ?? $eksporTertinggi->komoditas
        ?? 'Tidak tersedia';

    $imporTop = $imporTertinggi->nama_barang
        ?? $imporTertinggi->komoditas
        ?? 'Tidak tersedia';

    // ================= SMART NARASI (BI STYLE) =================
    $narasi = "Analisis perdagangan menunjukkan kondisi {$status} dengan dominasi {$dominasi}. ";

    $narasi .= "Ekspor menyumbang " . round($kontribusiEkspor, 2) . "% dari total perdagangan, ";
    $narasi .= "sedangkan impor menyumbang " . round($kontribusiImpor, 2) . "%. ";

    $narasi .= "Selisih perdagangan tercatat sebesar $ " . number_format(abs($selisih)) . ". ";

    if ($growth > 5) {
        $narasi .= "Pertumbuhan ekspor tinggi sebesar " . round($growth, 2) . "% menunjukkan ekspansi kuat sektor perdagangan. ";
    } elseif ($growth > 0) {
        $narasi .= "Pertumbuhan ekspor sebesar " . round($growth, 2) . "% menunjukkan tren positif namun moderat. ";
    } elseif ($growth < 0) {
        $narasi .= "Ekspor mengalami penurunan sebesar " . abs(round($growth, 2)) . "% yang mengindikasikan perlambatan ekonomi. ";
    } else {
        $narasi .= "Ekspor relatif stagnan tanpa perubahan signifikan. ";
    }

// ================= INSIGHT POINTS (VERSI EDUKATIF) =================

$points = [
    "Total perdagangan (gabungan ekspor + impor): $ " . number_format($totalPerdagangan),

    "Kontribusi ekspor terhadap total perdagangan: " . round($kontribusiEkspor, 2) . "%",

    "Kontribusi impor terhadap total perdagangan: " . round($kontribusiImpor, 2) . "%",

    "Selisih perdagangan (ekspor - impor): $ " . number_format($selisih),

    "Komoditas ekspor dominan: " . $eksporTop,

    "Komoditas impor dominan: " . $imporTop,

    "Status ekonomi saat ini: " . $status,

    "Dominasi perdagangan: " . $dominasi
];

    return [
        'ekspor_tertinggi' => $eksporTertinggi,
        'impor_tertinggi' => $imporTertinggi,

        'total_ekspor' => $totalEkspor,
        'total_impor' => $totalImpor,
        'selisih' => $selisih,

        'growth' => $growth,
        'status' => $status,

        // 🔥 BI METRICS BARU
        'ratio' => $ratio,
        'dominasi' => $dominasi,
        'kontribusi_ekspor' => $kontribusiEkspor,
        'kontribusi_impor' => $kontribusiImpor,

        'narasi' => $narasi,
        'points' => $points
    ];
}
}