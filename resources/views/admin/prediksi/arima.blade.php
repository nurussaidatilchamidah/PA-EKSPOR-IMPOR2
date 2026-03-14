@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto">

<h1 class="text-2xl font-bold mb-6">
Analisis dan Prediksi Ekspor Menggunakan Metode ARIMA
</h1>

<!-- CARD STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Prediksi Periode Berikutnya</h3>
<p class="text-2xl font-bold text-blue-600">
{{ number_format($prediksiEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
Nilai prediksi diperoleh menggunakan metode ARIMA yang mempelajari pola 
dari data historis ekspor sebelumnya. Model kemudian menghasilkan estimasi 
nilai ekspor untuk periode berikutnya berdasarkan pola data tersebut.
</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Mean Absolute Error (MAE)</h3>
<p class="text-2xl font-bold text-green-600">
{{ number_format($maeEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
MAE (Mean Absolute Error) menunjukkan rata-rata selisih antara nilai aktual 
dengan nilai hasil prediksi. Nilai MAE yang lebih kecil menunjukkan bahwa model 
prediksi memiliki tingkat akurasi yang lebih baik.
</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-gray-500 text-sm">Root Mean Square Error (RMSE)</h3>
<p class="text-2xl font-bold text-red-600">
{{ number_format($rmseEkspor,0,',','.') }}
</p>
<p class="text-muted small mt-2">
RMSE (Root Mean Square Error) digunakan untuk mengukur 
tingkat kesalahan model prediksi dengan memberikan penalti
lebih besar terhadap kesalahan yang besar. Semakin kecil 
nilai RMSE maka performa model prediksi semakin baik.
</p>
</div>

</div>

<!-- GRAFIK -->
<div class="bg-white shadow rounded-lg p-6 mb-8">

<h2 class="text-lg font-semibold mb-4">
Grafik Data Ekspor dan Prediksi ARIMA
</h2>

<canvas id="chartEkspor"></canvas>

</div>

<!-- PENJELASAN PERHITUNGAN -->
<div class="bg-white shadow rounded-lg p-6">

<h2 class="text-lg font-semibold mb-4">
Penjelasan Perhitungan Metode ARIMA
</h2>

<p class="mb-3">
Metode ARIMA (AutoRegressive Integrated Moving Average) digunakan untuk
melakukan peramalan data time series berdasarkan pola historis data.
Model yang digunakan pada penelitian ini adalah ARIMA(1,1,1).
</p>

<ul class="list-disc ml-6 space-y-2">

<li>
<strong>AR (AutoRegressive)</strong> menggunakan hubungan antara nilai sekarang
dengan nilai sebelumnya.
</li>

<li>
<strong>I (Integrated)</strong> digunakan untuk membuat data menjadi stasioner
melalui proses differencing.
</li>

<li>
<strong>MA (Moving Average)</strong> menggunakan error pada periode sebelumnya
untuk memperbaiki prediksi.
</li>

<li>
Evaluasi model dilakukan menggunakan nilai <strong>MAE</strong> dan
<strong>RMSE</strong> untuk mengukur tingkat kesalahan prediksi.
</li>

</ul>

</div>

</div>

<!-- CHART.JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('chartEkspor');

new Chart(ctx, {
type: 'line',
data: {
labels: {!! json_encode($labels) !!},
datasets: [

{
label: 'Data Ekspor',
data: {!! json_encode($dataEkspor) !!},
borderWidth: 2
},

{
label: 'Data Impor',
data: {!! json_encode($dataImpor) !!},
borderWidth: 2
}

]
},
options: {
responsive: true
}
});

</script>

@endsection