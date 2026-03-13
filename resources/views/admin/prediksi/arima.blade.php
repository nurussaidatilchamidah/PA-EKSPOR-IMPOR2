@extends('layouts.app')

@section('content')

<h1>Prediksi ARIMA</h1>

<p>Prediksi: {{ $prediksiEkspor }}</p>
<p>MAE: {{ $maeEkspor }}</p>
<p>RMSE: {{ $rmseEkspor }}</p>

@endsection