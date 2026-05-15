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
    <p>MAPE: <strong>{{ number_format($mapeEkspor,2) }}%</strong> (sangat baik)</p>

    <p class="mt-3 text-sm text-gray-600">
        MAE menunjukkan rata-rata selisih prediksi terhadap data aktual, RMSE memberikan penalti lebih besar 
        pada kesalahan yang besar, sedangkan MAPE menunjukkan rata-rata kesalahan prediksi dalam bentuk persentase terhadap data aktual.
    </p>
</div>

<!-- IMPOR -->
<div class="bg-white shadow rounded-lg p-6">
    <h3 class="font-semibold mb-3 text-green-600">Evaluasi Impor</h3>

    <p>MAE: <strong>{{ number_format($maeImpor,2) }}</strong></p>
    <p>RMSE: <strong>{{ number_format($rmseImpor,2) }}</strong></p>
    <p>MAPE: <strong>{{ number_format($mapeImpor,2) }}%</strong> (baik)</p>

    <p class="mt-3 text-sm text-gray-600">
        Nilai MAE dan RMSE ini menunjukkan tingkat kesalahan rata-rata model dalam memprediksi data impor, 
        sedangkan nilai MAPE menunjukkan tingkat kesalahan model dalam bentuk persentase sehingga mudah diinterpretasikan.
    </p>
</div>

</div>

<!-- PENJELASAN -->
<div class="bg-white shadow rounded-lg p-6 mt-4">

<div class="text-sm text-gray-700">

<h3 class="font-semibold mb-3">📘 Penjelasan Evaluasi Model</h3>

<p>
Evaluasi dilakukan dengan membandingkan data aktual dan hasil prediksi ARIMA menggunakan metrik MAE, RMSE, dan MAPE. 
MAE dan RMSE mengukur error dalam satuan USD, sedangkan MAPE menunjukkan error dalam bentuk persentase.
</p>

<p class="mt-2">
Semakin kecil nilai MAE, RMSE, dan MAPE, maka semakin baik akurasi model dalam melakukan peramalan.
</p>

</div>

<hr class="my-4">

<p class="text-sm text-gray-500 mt-2">
Kesimpulan: Model ARIMA memiliki tingkat akurasi yang baik pada data ekspor dan cukup baik pada data impor.
</p>

</div>

</div>

@endsection