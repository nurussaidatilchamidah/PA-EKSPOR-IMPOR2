@extends('layouts.admin')

@section('title', 'Edit Data Bulanan')

@section('content')

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('admin.data.update',$data->id) }}" method="POST">
@csrf
@method('PUT')

<div class="grid grid-cols-2 gap-4">

    {{-- TAHUN --}}
    <div>
        <label class="block font-semibold mb-1">Tahun</label>
        <input type="number" 
               name="tahun" 
               value="{{ $data->tahun }}" 
               class="border p-2 rounded w-full">
    </div>

    {{-- BULAN --}}
    <div>
        <label class="block font-semibold mb-1">Bulan</label>
        <select name="bulan" class="border p-2 rounded w-full">
            @foreach(['Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'] as $bulan)
                <option value="{{ $bulan }}" 
                    {{ $data->bulan == $bulan ? 'selected' : '' }}>
                    {{ $bulan }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- NILAI EKSPOR --}}
    <div>
        <label class="block font-semibold mb-1">Nilai Ekspor (USD)</label>
        <input type="text" 
               name="nilai_ekspor" 
               value="{{ $data->nilai_ekspor }}" 
               class="border p-2 rounded w-full">
    </div>

    {{-- BERAT EKSPOR --}}
    <div>
        <label class="block font-semibold mb-1">Berat Ekspor (Kg)</label>
        <input type="text" 
               name="berat_ekspor" 
               value="{{ $data->berat_ekspor }}" 
               class="border p-2 rounded w-full">
    </div>

    {{-- NILAI IMPOR --}}
    <div>
        <label class="block font-semibold mb-1">Nilai Impor (USD)</label>
        <input type="text" 
               name="nilai_impor" 
               value="{{ $data->nilai_impor }}" 
               class="border p-2 rounded w-full">
    </div>

    {{-- BERAT IMPOR --}}
    <div>
        <label class="block font-semibold mb-1">Berat Impor (Kg)</label>
        <input type="text" 
               name="berat_impor" 
               value="{{ $data->berat_impor }}" 
               class="border p-2 rounded w-full">
    </div>

</div>

<div class="mt-6">
    <button class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded">
        Update Data
    </button>
</div>

</form>

</div>

@endsection
