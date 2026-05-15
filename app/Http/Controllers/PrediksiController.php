<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;
use Carbon\Carbon;  

class PrediksiController extends Controller
{
    public function arima()
    {
        $data = DB::table('data_ekspor_impors')
            ->orderBy('id')
            ->get();

        $bulan = $data->pluck('tanggal')->map(function($b) {
            return \Carbon\Carbon::parse($b)->translatedFormat('M Y');
        })->toArray();

        $data_ekspor = $data->pluck('nilai_ekspor')->toArray();
        $data_impor = $data->pluck('nilai_impor')->toArray();

        $jsonEkspor = json_encode($data_ekspor);
        $jsonImpor = json_encode($data_impor);

        $python = "C:\\Users\\IDEAPAD\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
        $script = base_path('python/arima.py');

        // ================= EKSPOR =================
        $processEkspor = new Process([$python, $script, $jsonEkspor]);
        $processEkspor->run();

        if (!$processEkspor->isSuccessful()) {
            dd("Error Python Ekspor:", $processEkspor->getErrorOutput());
        }

        $outputEkspor = trim($processEkspor->getOutput());

        if (!$outputEkspor) {
            dd("Python tidak mengembalikan output EKSPOR");
        }

        $resultEkspor = json_decode($outputEkspor, true);

        if (!$resultEkspor) {
            dd("Output Python tidak valid:", $outputEkspor);
        }

        $model = $resultEkspor['model'];
        
        // ================= IMPOR =================
        $processImpor = new Process([$python, $script, $jsonImpor]);
        $processImpor->run();

        if (!$processImpor->isSuccessful()) {
            dd("Error Python Impor:", $processImpor->getErrorOutput());
        }

        $outputImpor = trim($processImpor->getOutput());

        if (!$outputImpor) {
            dd("Python tidak mengembalikan output IMPOR");
        }

        $resultImpor = json_decode($outputImpor, true);

        // ================= DATA GRAFIK =================

        // data asli
        $dataEkspor = array_map('floatval', $data_ekspor);
        $dataImpor = array_map('floatval', $data_impor);

        // prediksi (anggap 1 langkah dulu biar stabil)
        $forecastEkspor = (array) $resultEkspor['prediksi'];
        $forecastImpor = (array) $resultImpor['prediksi'];

        // labels
        $labels = $bulan;

        // tambahkan label prediksi
        $lastDate = \Carbon\Carbon::parse($data->last()->tanggal);

        // looping sesuai jumlah prediksi
        foreach ($forecastEkspor as $i => $v) {
            $nextDate = $lastDate->copy()->addMonths($i + 1);
            $labels[] = $nextDate->translatedFormat('M Y');
        }

        // ================= DATA HISTORIS =================

        // historis + null di akhir
        $dataEksporChart = $dataEkspor;
        $dataImporChart = $dataImpor;

        foreach ($forecastEkspor as $v) {
            $dataEksporChart[] = null;
            $dataImporChart[] = null;
        }

        // ================= DATA PREDIKSI =================

        // null sepanjang historis
        $dataPrediksiEkspor = array_fill(0, count($dataEkspor), null);
        $dataPrediksiImpor = array_fill(0, count($dataImpor), null);

        // langsung tambah prediksi
        foreach ($forecastEkspor as $v) {
            $dataPrediksiEkspor[] = $v;
        }
        foreach ($forecastImpor as $v) {
            $dataPrediksiImpor[] = $v;
        }

       // ================= MAPE EKSPOR =================
        $totalErrorEkspor = 0;
        $countEkspor = 0;

        foreach ($data_ekspor as $i => $actual) {
            $predicted = $resultEkspor['prediksi'][$i] ?? null;

            if ($predicted !== null && $actual != 0) {
                $totalErrorEkspor += abs(($actual - $predicted) / $actual);
                $countEkspor++;
            }
        }

        $mapeEkspor = $countEkspor > 0 ? ($totalErrorEkspor / $countEkspor) * 100 : 0;


        // ================= MAPE IMPOR =================
        $totalErrorImpor = 0;
        $countImpor = 0;

        foreach ($data_impor as $i => $actual) {
            $predicted = $resultImpor['prediksi'][$i] ?? null;

            if ($predicted !== null && $actual != 0) {
                $totalErrorImpor += abs(($actual - $predicted) / $actual);
                $countImpor++;
            }
        }

        $mapeImpor = $countImpor > 0 ? ($totalErrorImpor / $countImpor) * 100 : 0;

        // ================= VIEW =================
        return view('admin.prediksi.arima', [
            'prediksiEkspor' => $resultEkspor['prediksi'],
            'maeEkspor' => $resultEkspor['mae'],
            'rmseEkspor' => $resultEkspor['rmse'],
            'modelARIMA' => $model,

            'prediksiImpor' => $resultImpor['prediksi'],
            'maeImpor' => $resultImpor['mae'],
            'rmseImpor' => $resultImpor['rmse'],
            'mapeEkspor' => $mapeEkspor,
            'mapeImpor' => $mapeImpor,

            'labels' => $labels,
            'dataEkspor' => $dataEksporChart,
            'dataImpor' => $dataImporChart,
            'dataPrediksiEkspor' => $dataPrediksiEkspor,
            'dataPrediksiImpor' => $dataPrediksiImpor,
        ]);
    }

// ================= EVALUASI MODEL =================
public function evaluasi()
{
    $data = DB::table('data_ekspor_impors')
        ->orderBy('id')
        ->get();

    // ambil tanggal buat label
    $labels = $data->pluck('tanggal')->map(function($tgl) {
        return \Carbon\Carbon::parse($tgl)->translatedFormat('M Y');
    })->toArray();

    $data_ekspor = $data->pluck('nilai_ekspor')->toArray();
    $data_impor = $data->pluck('nilai_impor')->toArray();

    $jsonEkspor = json_encode($data_ekspor);
    $jsonImpor = json_encode($data_impor);

    $python = "C:\\Users\\IDEAPAD\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
    $script = base_path('python/arima.py');

    // ===== EKSPOR =====
    $processEkspor = new Process([$python, $script, $jsonEkspor]);
    $processEkspor->run();

    if (!$processEkspor->isSuccessful()) {
        dd("Error Python Ekspor:", $processEkspor->getErrorOutput());
    }

    $resultEkspor = json_decode(trim($processEkspor->getOutput()), true);

    // ===== IMPOR =====
    $processImpor = new Process([$python, $script, $jsonImpor]);
    $processImpor->run();

    if (!$processImpor->isSuccessful()) {
        dd("Error Python Impor:", $processImpor->getErrorOutput());
    }

    $resultImpor = json_decode(trim($processImpor->getOutput()), true);

    // ================= TAMBAHAN PENTING =================

    $testCount = 3; // sesuai python (test = 3 data terakhir)

    // ===== evaluasi ekspor =====
    $evaluasiEkspor = [];
    for ($i = 0; $i < $testCount; $i++) {
        $index = count($data_ekspor) - $testCount + $i;

        $evaluasiEkspor[] = [
            'periode' => $labels[$index],
            'aktual' => $data_ekspor[$index],
            'prediksi' => $resultEkspor['prediksi'][$i] ?? 0,
        ];
    }

    // ===== evaluasi impor =====
    $evaluasiImpor = [];
    for ($i = 0; $i < $testCount; $i++) {
        $index = count($data_impor) - $testCount + $i;

        $evaluasiImpor[] = [
            'periode' => $labels[$index],
            'aktual' => $data_impor[$index],
            'prediksi' => $resultImpor['prediksi'][$i] ?? 0,
        ];
    }

            // ================= MAPE EKSPOR =================
        $totalErrorEkspor = 0;
        $countEkspor = 0;

        foreach ($evaluasiEkspor as $row) {
            if ($row['aktual'] != 0) {
                $totalErrorEkspor += abs(($row['aktual'] - $row['prediksi']) / $row['aktual']);
                $countEkspor++;
            }
        }

        $mapeEkspor = $countEkspor > 0 ? ($totalErrorEkspor / $countEkspor) * 100 : 0;


        // ================= MAPE IMPOR =================
        $totalErrorImpor = 0;
        $countImpor = 0;

        foreach ($evaluasiImpor as $row) {
            if ($row['aktual'] != 0) {
                $totalErrorImpor += abs(($row['aktual'] - $row['prediksi']) / $row['aktual']);
                $countImpor++;
            }
        }

        $mapeImpor = $countImpor > 0 ? ($totalErrorImpor / $countImpor) * 100 : 0;

    // ================= VIEW =================
    return view('admin.prediksi.evaluasi', [
        'maeEkspor' => $resultEkspor['mae'],
        'rmseEkspor' => $resultEkspor['rmse'],
        'maeImpor' => $resultImpor['mae'],
        'rmseImpor' => $resultImpor['rmse'],
        'modelARIMA' => $resultEkspor['model'],

        // tambahan
        'evaluasiEkspor' => $evaluasiEkspor,
        'evaluasiImpor' => $evaluasiImpor,
        'mapeEkspor' => $mapeEkspor,
        'mapeImpor' => $mapeImpor,
    ]);
}
}