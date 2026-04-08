<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEksporImpor;
use Symfony\Component\Process\Process;
use Carbon\Carbon;

class DashboardPublicController extends Controller
{
    public function index()
    {
        // ================= DATA =================
        $data = DataEksporImpor::orderBy('tanggal')->get();

        $bulan = $data->pluck('tanggal')->map(function($item){
            return Carbon::parse($item)->translatedFormat('M Y');
        })->toArray();

        $data_ekspor = $data->pluck('nilai_ekspor')->toArray();
        $data_impor = $data->pluck('nilai_impor')->toArray();

        // ================= TOTAL =================
        $total_ekspor = array_sum($data_ekspor);
        $total_impor = array_sum($data_impor);
        $selisih = $total_ekspor - $total_impor;

        // ================= ARIMA =================
        $python = "C:\\Users\\IDEAPAD\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
        $script = base_path('python/arima.py');

        // ===== EKSPOR =====
        $processEkspor = new Process([$python, $script, json_encode($data_ekspor)]);
        $processEkspor->run();

        if (!$processEkspor->isSuccessful()) {
            dd("Error Python Ekspor:", $processEkspor->getErrorOutput());
        }

        $resultEkspor = json_decode(trim($processEkspor->getOutput()), true);

        // ===== IMPOR =====
        $processImpor = new Process([$python, $script, json_encode($data_impor)]);
        $processImpor->run();

        if (!$processImpor->isSuccessful()) {
            dd("Error Python Impor:", $processImpor->getErrorOutput());
        }

        $resultImpor = json_decode(trim($processImpor->getOutput()), true);

        // ================= PREDIKSI =================
        $forecastEkspor = (array) $resultEkspor['prediksi'];
        $forecastImpor = (array) $resultImpor['prediksi'];

        // ================= LABEL TAMBAHAN =================
        $labels = $bulan;
        $lastDate = Carbon::parse($data->last()->tanggal);

        foreach ($forecastEkspor as $i => $v) {
            $nextDate = $lastDate->copy()->addMonths($i + 1);
            $labels[] = $nextDate->translatedFormat('M Y');
        }

        // ================= DATA CHART =================

        // historis
        $dataEksporChart = $data_ekspor;
        $dataImporChart = $data_impor;

        foreach ($forecastEkspor as $v) {
            $dataEksporChart[] = null;
            $dataImporChart[] = null;
        }

        // prediksi
        $dataPrediksiEkspor = array_fill(0, count($data_ekspor), null);
        $dataPrediksiImpor = array_fill(0, count($data_impor), null);

        foreach ($forecastEkspor as $v) {
            $dataPrediksiEkspor[] = $v;
        }

        foreach ($forecastImpor as $v) {
            $dataPrediksiImpor[] = $v;
        }

        // ================= VIEW =================
        return view('dashboard-public', [
            'labels' => $labels,
            'dataEkspor' => $dataEksporChart,
            'dataImpor' => $dataImporChart,
            'dataPrediksiEkspor' => $dataPrediksiEkspor,
            'dataPrediksiImpor' => $dataPrediksiImpor,

            'total_ekspor' => $total_ekspor,
            'total_impor' => $total_impor,
            'selisih' => $selisih,
        ]);
    }
}