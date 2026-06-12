<?php

namespace App\Services;

use App\Models\DataEksporImpor;
use Carbon\Carbon;

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
    $impor = $data->pluck('nilai_impor')->values();

    $firstEkspor = $ekspor->first();
    $lastEkspor = $ekspor->last();

    $firstImpor = $impor->first();
    $lastImpor = $impor->last();

    $growthEkspor = $firstEkspor != 0
        ? (($lastEkspor - $firstEkspor) / $firstEkspor) * 100
        : 0;

    $growthImpor = $firstImpor != 0
        ? (($lastImpor - $firstImpor) / $firstImpor) * 100
        : 0;

    // ================= STATUS =================
    $status = $selisih > 0
        ? "Surplus perdagangan"
        : "Defisit perdagangan";

   
// ================= INSIGHT POINTS (VERSI EDUKATIF) =================

$points = [
    "Total perdagangan (gabungan ekspor + impor): $ " . number_format($totalPerdagangan),

    "Kontribusi ekspor terhadap total perdagangan: " . round($kontribusiEkspor, 2) . "%",

    "Kontribusi impor terhadap total perdagangan: " . round($kontribusiImpor, 2) . "%",

    "Status ekonomi saat ini: " . $status,

    "Dominasi perdagangan: " . $dominasi
];

return [
    'total_ekspor' => $totalEkspor,
    'total_impor' => $totalImpor,
    'selisih' => $selisih,

    'status' => $status,

    'growth_ekspor' => $growthEkspor,
    'growth_impor' => $growthImpor,

    'ratio' => $ratio,
    'dominasi' => $dominasi,

    'kontribusi_ekspor' => $kontribusiEkspor,
    'kontribusi_impor' => $kontribusiImpor,

    'periode_ekspor_tertinggi' =>
        \Carbon\Carbon::parse($eksporTertinggi->tanggal)
            ->translatedFormat('F Y'),

    'nilai_ekspor_tertinggi' =>
        $eksporTertinggi->nilai_ekspor,

    'periode_impor_tertinggi' =>
        \Carbon\Carbon::parse($imporTertinggi->tanggal)
            ->translatedFormat('F Y'),

    'nilai_impor_tertinggi' =>
        $imporTertinggi->nilai_impor
];
}
}