@extends('layouts.admin')

@section('content')

<h1 class="text-xl font-bold mb-6">
Prediksi Ekspor dan Impor Menggunakan Metode ARIMA
</h1>

<!-- CARD STATISTIK -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-black-500 text-sm">Prediksi Ekspor</h3>
<p class="text-2xl font-bold text-blue-600">
{{ number_format($prediksiEkspor[0] ?? 0,0,',','.') }}
</p>
<p class="text-gray-500 text-sm mt-2">
Nilai prediksi diperoleh menggunakan metode ARIMA berdasarkan pola historis data ekspor sebelumnya.
</p>
</div>

<div class="bg-white shadow rounded-lg p-6">
<h3 class="text-black-500 text-sm">Prediksi Impor</h3>
<p class="text-2xl font-bold text-orange-500">
{{ number_format($prediksiImpor[0] ?? 0,0,',','.') }}
</p>
<p class="text-gray-500 text-sm mt-2">
Nilai prediksi diperoleh menggunakan metode ARIMA berdasarkan pola historis data impor sebelumnya.
</p>
</div>

</div>

<!-- GRAFIK -->
<div class="bg-white shadow rounded-lg p-6 mb-8">

<h2 class="text-lg font-semibold mb-4">
Grafik Data Ekspor dan Impor dengan Prediksi ARIMA
</h2>

<canvas id="chartEkspor" height="100"></canvas>

</div>

<p class="text-sm text-gray-600 mt-4">
Berdasarkan hasil pemodelan ARIMA, nilai ekspor pada periode berikutnya diperkirakan sebesar 
<strong>{{ number_format($prediksiEkspor[0] ?? 0,0,',','.') }}</strong>.
Prediksi ini dihasilkan dari analisis pola data historis yang telah dimodelkan menggunakan metode ARIMA.
</p>

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

{{-- DATA HISTORIS --}}
@foreach($labels as $i => $periode)
    @if($i < count($dataEkspor))
    <tr class="text-center">
        <td class="border px-4 py-2">{{ $periode }}</td>
        <td class="border px-4 py-2">
            {{ number_format($dataEkspor[$i],0,',','.') }}
        </td>
        <td class="border px-4 py-2">-</td>
    </tr>
    @endif
@endforeach

{{-- DATA PREDIKSI --}}
@foreach($prediksiEkspor as $i => $pred)
<tr class="text-center bg-blue-50">
    <td class="border px-4 py-2">Prediksi {{ $i+1 }}</td>
    <td class="border px-4 py-2">-</td>
    <td class="border px-4 py-2 text-blue-600 font-semibold">
        {{ number_format($pred,0,',','.') }}
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