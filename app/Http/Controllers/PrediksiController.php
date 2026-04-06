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

        // ================= VIEW =================
        return view('admin.prediksi.arima', [
            'prediksiEkspor' => $resultEkspor['prediksi'],
            'maeEkspor' => $resultEkspor['mae'],
            'rmseEkspor' => $resultEkspor['rmse'],
            'modelARIMA' => $model,

            'prediksiImpor' => $resultImpor['prediksi'],
            'maeImpor' => $resultImpor['mae'],
            'rmseImpor' => $resultImpor['rmse'],

            'labels' => $labels,
            'dataEkspor' => $dataEksporChart,
            'dataImpor' => $dataImporChart,
            'dataPrediksiEkspor' => $dataPrediksiEkspor,
            'dataPrediksiImpor' => $dataPrediksiImpor,
        ]);
    }
}