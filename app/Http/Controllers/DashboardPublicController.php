<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEksporImpor;
use Symfony\Component\Process\Process;
use Carbon\Carbon;
use App\Models\DataHs;
use App\Services\InsightService;

class DashboardPublicController extends Controller
{
    public function index(Request $request)
    {
        // ================= DATA =================
        $data = DataEksporImpor::orderBy('tanggal')->get();

        $bulan = $data->pluck('tanggal')->map(function($item){
            return Carbon::parse($item)->translatedFormat('M Y');
        })->toArray();

        $data_ekspor = $data->pluck('nilai_ekspor')->toArray();
        $data_impor = $data->pluck('nilai_impor')->toArray();

        // ================= TOTAL =================
        $insight = (new \App\Services\InsightService())->getInsight();

        $total_ekspor = $insight['total_ekspor'];
        $total_impor = $insight['total_impor'];
        $selisih = $insight['selisih'];

        // ================= ARIMA =================
        $python = "C:\\Users\\IDEAPAD\\AppData\\Local\\Programs\\Python\\Python313\\python.exe";
        $script = base_path('python/arima.py');

        // EKSPOR
        $processEkspor = new Process([$python, $script, json_encode($data_ekspor)]);
        $processEkspor->run();

        if (!$processEkspor->isSuccessful()) {
            dd("Error Python Ekspor:", $processEkspor->getErrorOutput());
        }

        $resultEkspor = json_decode(trim($processEkspor->getOutput()), true);

        // IMPOR
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
        // ================= CHART =================
        $dataEksporChart = $data_ekspor;
        $dataImporChart = $data_impor;

        foreach ($forecastEkspor as $v) {
            $dataEksporChart[] = null;
            $dataImporChart[] = null;
        }

        $dataPrediksiEkspor = array_fill(0, count($data_ekspor), null);
        $dataPrediksiImpor = array_fill(0, count($data_impor), null);

        foreach ($forecastEkspor as $v) {
            $dataPrediksiEkspor[] = $v;
        }

        foreach ($forecastImpor as $v) {
            $dataPrediksiImpor[] = $v;
        }

        // ================= FIX ARRAY =================
        $dataEksporChart = array_values($dataEksporChart);
        $dataImporChart = array_values($dataImporChart);

        // ================= EVALUASI =================
        $mae = 0;
        $rmse = 0;

        if(count($forecastEkspor) > 0){
            $actual = array_slice($data_ekspor, -count($forecastEkspor));
            $errors = [];

            foreach ($forecastEkspor as $i => $pred) {
                $errors[] = ($actual[$i] ?? 0) - $pred;
            }

            $mae = array_sum(array_map(fn($e) => abs($e), $errors)) / count($errors);
            $rmse = sqrt(array_sum(array_map(fn($e) => pow($e,2), $errors)) / count($errors));
        }

        // ================= INSIGHT =================
        $periodeTertinggi = count($data_ekspor) 
            ? $labels[array_search(max($data_ekspor), $data_ekspor)] 
            : '-';

        $periodeImporTertinggi = count($data_impor) 
            ? $labels[array_search(max($data_impor), $data_impor)] 
            : '-';

        $trend = end($data_ekspor) > $data_ekspor[0] ? 'Meningkat 📈' : 'Menurun 📉';

    // ================= NERACA =================
    $neracaPeriode = [];

    foreach ($data as $item) {
        $selisihPeriode = $item->nilai_ekspor - $item->nilai_impor;

        $neracaPeriode[] = [
            'tanggal' => Carbon::parse($item->tanggal)->translatedFormat('M Y'),
            'selisih' => $selisihPeriode,
            'status' => $selisihPeriode > 0 ? 'Surplus' : 'Defisit'
        ];
    }

    $totalSurplus = count(array_filter($neracaPeriode, function($n) {
        return $n['selisih'] > 0;
    }));

    $totalDefisit = count(array_filter($neracaPeriode, function($n) {
        return $n['selisih'] <= 0;
    }));

            // ================= KOMODITAS =================
    $topEkspor = DataHs::select('nama_barang')
        ->selectRaw('SUM(nilai_ekspor) as total')
        ->groupBy('nama_barang')
        ->orderByDesc('total')
        ->limit(10)
        ->get();
    $topImpor = DataHs::select('nama_barang')
        ->selectRaw('SUM(nilai_impor) as total')
        ->groupBy('nama_barang')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

        // ========== INSIGHT ==========
    $insightService = new InsightService();
    $insight = $insightService->getInsight();

        // ================= VIEW =================
        return view('welcome', [
            'data' => $data,
            'labels' => $labels,
            'dataEkspor' => $dataEksporChart,
            'dataImpor' => $dataImporChart,
            'dataPrediksiEkspor' => $dataPrediksiEkspor,
            'dataPrediksiImpor' => $dataPrediksiImpor,
            'total_ekspor' => $total_ekspor,
            'total_impor' => $total_impor,
            'selisih' => $selisih,
            'mae' => $mae,
            'rmse' => $rmse,
            'periodeTertinggi' => $periodeTertinggi,
            'periodeImporTertinggi' => $periodeImporTertinggi,
            'trend' => $trend,
            'neracaPeriode' => $neracaPeriode,
            'totalSurplus' => $totalSurplus,
            'totalDefisit' => $totalDefisit,
            'topEkspor' => $topEkspor,
            'topImpor' => $topImpor,
            'insight' => $insight
        ]);
    }
}