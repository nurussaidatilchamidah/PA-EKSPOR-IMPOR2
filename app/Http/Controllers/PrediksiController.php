<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class PrediksiController extends Controller
{
    public function arima()
    {
        $data = DB::table('data_ekspor_impors')
            ->orderBy('id')
            ->get();

        $bulan = $data->pluck('bulan')->toArray();

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

        $labels = $bulan;

        // Tambah label prediksi
        $labels[] = "Prediksi";

        $dataEksporChart = $data_ekspor;
        $dataEksporChart[] = $resultEkspor['prediksi'];

        $dataImporChart = $data_impor;
        $dataImporChart[] = $resultImpor['prediksi'];

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
            'dataImpor' => $dataImporChart
        ]);
    }
}