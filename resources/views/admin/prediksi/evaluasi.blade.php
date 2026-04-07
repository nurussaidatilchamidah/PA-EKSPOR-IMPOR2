@extends('layouts.admin')

@section('content')

<h1 class="text-xl font-bold mb-6">
Evaluasi Model ARIMA
</h1>

<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-lg font-semibold mb-4">Model yang Digunakan</h2>
    <p class="text-gray-700">
        Model ARIMA yang digunakan adalah <strong>{{ $modelARIMA }}</strong>
    </p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<!-- EKSPOR -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-3 text-blue-600">Evaluasi Ekspor</h3>

    <p>MAE: <strong>{{ number_format($maeEkspor,2) }}</strong></p>
    <p>RMSE: <strong>{{ number_format($rmseEkspor,2) }}</strong></p>
</div>

<!-- IMPOR -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-3 text-green-600">Evaluasi Impor</h3>

    <p>MAE: <strong>{{ number_format($maeImpor,2) }}</strong></p>
    <p>RMSE: <strong>{{ number_format($rmseImpor,2) }}</strong></p>
</div>

</div>

<h3 class="font-semibold mt-6 mb-2">Perbandingan Data Aktual vs Prediksi</h3>

<table class="table-auto w-full border">
    <thead>
        <tr class="bg-gray-100">
            <th class="border px-2 py-1">Periode</th>
            <th class="border px-2 py-1">Aktual</th>
            <th class="border px-2 py-1">Prediksi</th>
            <th class="border px-2 py-1">Error</th>
        </tr>
    </thead>
    <tbody>
        @foreach($evaluasiEkspor as $i => $row)
        <tr class="text-center">
            <td class="border px-2 py-1">{{ $row['periode'] }}</td>
            <td class="border px-2 py-1">{{ number_format($row['aktual']) }}</td>
            <td class="border px-2 py-1">{{ number_format($row['prediksi']) }}</td>
            <td class="border px-2 py-1 text-red-500">
                {{ number_format(abs($row['aktual'] - $row['prediksi'])) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- PENJELASAN -->
<div class="bg-white shadow rounded-lg p-6 mt-3">

<div class="mt-6 text-sm text-gray-700">
<h3 class="font-semibold mt-6 mb-2">Cara Perhitungan Evaluasi Model</h3>

<p>
Evaluasi dilakukan dengan membandingkan data asli dengan hasil prediksi pada 3 periode terakhir.
</p>

<p class="mt-2">
Selisih antara data asli dan prediksi disebut <strong>error</strong>.
</p>

<p class="mt-2">
<strong>MAE</strong> adalah rata-rata dari semua error.
</p>

<p class="mt-2">
<strong>RMSE</strong> adalah error yang dikuadratkan lalu dirata-rata dan diakar.
</p>

<p class="mt-2">
Semakin kecil nilai MAE dan RMSE, maka hasil prediksi semakin akurat.
</p>
</div>

</div>

@endsection