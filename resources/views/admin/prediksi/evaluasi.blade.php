@extends('layouts.admin')

@section('content')

<h1 class="text-xl font-bold mb-6">
Evaluasi Model ARIMA
</h1>

<!-- MODEL -->
<div class="bg-white shadow rounded-lg p-6 mb-6">
    <h2 class="text-lg font-semibold mb-4">Model yang Digunakan</h2>
    <p class="text-gray-700">
        Model ARIMA yang digunakan adalah <strong>{{ $modelARIMA }}</strong>
    </p>
</div>

<!-- METRIK -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<!-- EKSPOR -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-3 text-blue-600">Evaluasi Ekspor</h3>

    <p>MAE: <strong>{{ number_format($maeEkspor,2) }}</strong></p>
    <p>RMSE: <strong>{{ number_format($rmseEkspor,2) }}</strong></p>

    <p class="mt-3 text-sm text-gray-600">
        MAE menunjukkan rata-rata selisih prediksi terhadap data aktual, 
        sedangkan RMSE memberikan penalti lebih besar pada kesalahan yang besar.
    </p>
</div>

<!-- IMPOR -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-3 text-green-600">Evaluasi Impor</h3>

    <p>MAE: <strong>{{ number_format($maeImpor,2) }}</strong></p>
    <p>RMSE: <strong>{{ number_format($rmseImpor,2) }}</strong></p>

    <p class="mt-3 text-sm text-gray-600">
        Nilai ini menunjukkan tingkat kesalahan rata-rata model dalam memprediksi data impor.
    </p>
</div>

</div>

<!-- TABEL -->
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
        @foreach($evaluasiEkspor as $row)
        <tr class="text-center">
            <td class="border px-2 py-1">{{ $row['periode'] }}</td>
            <td class="border px-2 py-1">{{ number_format($row['aktual']) }}</td>
            <td class="border px-2 py-1">{{ number_format($row['prediksi']) }}</td>

            @php
                $error = abs($row['aktual'] - $row['prediksi']);
                $persen = $row['aktual'] > 0 ? ($error / $row['aktual']) * 100 : 0;
            @endphp

            <td class="border px-2 py-1 
                {{ $persen > 10 ? 'text-red-500' : 'text-green-600' }}">
                {{ number_format($error) }}
                <br>
                <span class="text-xs text-gray-500">
                    ({{ number_format($persen,2) }}%)
                </span>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- PENJELASAN -->
<div class="bg-white shadow rounded-lg p-6 mt-4">

<div class="text-sm text-gray-700">

<h3 class="font-semibold mb-3">📘 Penjelasan Evaluasi Model</h3>

<p>
Evaluasi ini dilakukan dengan membandingkan data aktual dan hasil prediksi ARIMA pada beberapa periode terakhir.
Model yang digunakan adalah <strong>{{ $modelARIMA }}</strong> sehingga pola data historis digunakan untuk memprediksi nilai berikutnya.
</p>

<p class="mt-2">
Perbandingan ini menghasilkan tiga komponen utama:
</p>

<ul class="list-disc ml-5 mt-2">
    <li><strong>Aktual</strong> → data asli dari sistem</li>
    <li><strong>Prediksi</strong> → hasil peramalan model ARIMA</li>
    <li><strong>Error</strong> → selisih antara keduanya</li>
</ul>

<hr class="my-4">

<h3 class="font-semibold mb-2">📊 Cara Kerja MAE & RMSE</h3>

<p>
<strong>MAE</strong> menghitung rata-rata selisih absolut antara data aktual dan prediksi.
</p>

<p class="mt-2">
<strong>RMSE</strong> menghitung error yang dikuadratkan sehingga lebih sensitif terhadap kesalahan besar.
</p>

<p class="mt-3">
Semakin kecil nilai MAE dan RMSE, semakin baik kemampuan model dalam mengikuti pola data.
</p>

<hr class="my-4">

<h3 class="font-semibold mb-2">📌 Interpretasi Tambahan</h3>

<p>
Persentase error pada tabel membantu melihat tingkat kesalahan relatif terhadap besarnya data.
Jika persentase kecil, maka meskipun nilai error terlihat besar secara nominal, model tetap dianggap cukup akurat.
</p>

</div>

</div>

@endsection