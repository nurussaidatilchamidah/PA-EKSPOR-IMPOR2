@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-4">

<h1 class="text-2xl font-bold mb-6">
Analisis dan Prediksi Ekspor dan Impor Menggunakan Metode ARIMA
</h1>

<!-- CARD STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Prediksi Periode Berikutnya</h3>
<p class="text-2xl font-bold text-blue-600">
{{ number_format($prediksiEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
Nilai prediksi diperoleh menggunakan metode ARIMA berdasarkan pola historis data ekspor sebelumnya.
</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Mean Absolute Error (MAE)</h3>
<p class="text-2xl font-bold text-green-600">
{{ number_format($maeEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
MAE menunjukkan rata-rata selisih antara nilai aktual dengan nilai prediksi.
Semakin kecil nilai MAE maka akurasi model semakin baik.
</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Root Mean Square Error (RMSE)</h3>
<p class="text-2xl font-bold text-red-600">
{{ number_format($rmseEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
RMSE mengukur tingkat kesalahan model dengan penalti lebih besar pada kesalahan besar.
Nilai RMSE yang kecil menunjukkan model prediksi yang lebih baik.
</p>
</div>

</div>


<!-- GRAFIK -->
<div class="bg-white shadow rounded-lg p-6 mb-8">

<h2 class="text-lg font-semibold mb-4">
Grafik Data Ekspor dan Impor dengan Prediksi ARIMA
</h2>

<canvas id="chartEkspor" height="100"></canvas>

<p class="text-sm text-gray-600 mt-4">
Berdasarkan hasil pemodelan ARIMA, nilai ekspor pada periode berikutnya diperkirakan sebesar 
<strong>{{ number_format($prediksiEkspor,0,',','.') }}</strong>.
Model memiliki tingkat kesalahan prediksi sebesar 
MAE <strong>{{ number_format($maeEkspor,0,',','.') }}</strong> dan 
RMSE <strong>{{ number_format($rmseEkspor,0,',','.') }}</strong>.
</p>

</div>


<!-- TABEL HASIL FORECAST -->
<div class="bg-white shadow rounded-lg p-6 mb-8">

<h2 class="text-lg font-semibold mb-4">
Tabel Hasil Prediksi ARIMA
</h2>

<div class="overflow-x-auto">

<table class="min-w-full border border-gray-200">

<thead class="bg-gray-100">
<tr>
<th class="px-4 py-2 border">Periode</th>
<th class="px-4 py-2 border">Data Ekspor</th>
<th class="px-4 py-2 border">Prediksi ARIMA</th>
</tr>
</thead>

<tbody>

@foreach($labels as $i => $periode)

<tr class="text-center">
<td class="border px-4 py-2">{{ $periode }}</td>
<td class="border px-4 py-2">
{{ number_format($dataEkspor[$i] ?? 0,0,',','.') }}
</td>
<td class="border px-4 py-2 text-blue-600 font-semibold">
{{ number_format($dataPrediksiEkspor[$i] ?? 0,0,',','.') }}
</td>
</tr>

@endforeach

</tbody>

</table>

</div>

</div>


<!-- PENJELASAN METODE -->
<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-lg font-semibold mb-4">
Penjelasan Perhitungan Metode ARIMA
</h2>

<p class="mb-3">
Metode ARIMA (AutoRegressive Integrated Moving Average) digunakan untuk melakukan peramalan data time series berdasarkan pola historis data. 
Model yang digunakan pada sistem ini adalah ARIMA(1,1,1).
</p>

<ul class="list-disc ml-6 space-y-2">

<li>
<strong>AR (AutoRegressive)</strong> menggunakan hubungan antara nilai sekarang dengan nilai periode sebelumnya.
</li>

<li>
<strong>I (Integrated)</strong> digunakan untuk membuat data menjadi stasioner melalui proses differencing.
</li>

<li>
<strong>MA (Moving Average)</strong> menggunakan error pada periode sebelumnya untuk memperbaiki hasil prediksi.
</li>

<li>
Evaluasi model dilakukan menggunakan nilai <strong>MAE</strong> dan <strong>RMSE</strong> untuk mengetahui tingkat akurasi model.
</li>

</ul>

</div>

</div>


<!-- CHART -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartEkspor');

new Chart(ctx, {
type: 'line',
data: {
labels: @json($labels),
datasets: [

{
label: 'Ekspor Historis',
data: @json($dataEkspor),
borderColor: 'blue',
borderWidth: 3,
tension: 0.3
},

{
label: 'Forecast ARIMA Ekspor',
data: @json($dataPrediksiEkspor),
borderColor: 'red',
borderDash: [6,6],
borderWidth: 3,
pointRadius: 6,
pointBackgroundColor: 'red',
tension: 0.3
},

{
label: 'Impor Historis',
data: @json($dataImpor),
borderColor: 'green',
borderWidth: 3,
tension: 0.3
},

{
label: 'Forecast ARIMA Impor',
data: @json($dataPrediksiImpor),
borderColor: 'orange',
borderDash: [6,6],
borderWidth: 3,
pointRadius: 6,
pointBackgroundColor: 'orange',
tension: 0.3
}

]
},

options: {

responsive: true,

plugins: {
legend: {
position: 'top'
}
},

scales: {
y: {
beginAtZero: false
}
}

}

});

</script>

@endsection