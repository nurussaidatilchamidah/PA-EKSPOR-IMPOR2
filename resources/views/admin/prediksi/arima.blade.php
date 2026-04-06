@extends('layouts.admin')

@section('content')

<h1 class="text-xl font-bold mb-3">
Prediksi Ekspor dan Impor Menggunakan Metode ARIMA
</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

</div>

<!-- GRAFIK -->
<div class="bg-white shadow rounded-lg p-6 mb-8">

<h2 class="text-lg font-semibold mb-4">
Grafik Data Ekspor dan Impor dengan Prediksi ARIMA
</h2>

<canvas id="chartEkspor" height="100"></canvas>

<p class="text-sm text-gray-500 mt-4 italic">
Data yang digunakan merupakan nilai ekspor dan impor bulanan (dalam satuan USD).
</p>

</div>

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