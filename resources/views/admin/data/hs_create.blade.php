@extends('layouts.admin')

@section('title', 'Tambah Data HS')

@section('content')

<div class="bg-white p-6 rounded shadow">

<form action="{{ route('admin.data.hs.store') }}" method="POST">
@csrf

<div class="grid grid-cols-2 gap-4">

    {{-- KODE HS --}}
    <div>
        <label class="block font-semibold mb-1">Kode HS</label>
        <select name="kode_hs" id="kode_hs"
            class="border p-2 rounded w-full"
            onchange="isiNamaBarang()">

            <option value="">-- Pilih Kode HS --</option>

            @foreach($masterHs as $hs)
                <option 
                    value="{{ $hs->kode_hs }}"
                    data-nama="{{ $hs->nama_barang }}">
                    {{ $hs->kode_hs }} - {{ $hs->nama_barang }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- NAMA BARANG --}}
    <div>
        <label class="block font-semibold mb-1">Deskripsi</label>
        <input type="text" 
               name="nama_barang" 
               id="nama_barang"
               class="border p-2 rounded w-full"
               readonly>
    </div>

    {{-- NILAI EKSPOR --}}
    <div>
        <label class="block font-semibold mb-1">Nilai Ekspor (USD)</label>
        <input type="text" name="nilai_ekspor"
               class="border p-2 rounded w-full">
    </div>

    {{-- BERAT EKSPOR --}}
    <div>
        <label class="block font-semibold mb-1">Berat Ekspor (Kg)</label>
        <input type="text" name="berat_ekspor"
               class="border p-2 rounded w-full">
    </div>

    {{-- NILAI IMPOR --}}
    <div>
        <label class="block font-semibold mb-1">Nilai Impor (USD)</label>
        <input type="text" name="nilai_impor"
               class="border p-2 rounded w-full">
    </div>

    {{-- BERAT IMPOR --}}
    <div>
        <label class="block font-semibold mb-1">Berat Impor (Kg)</label>
        <input type="text" name="berat_impor"
               class="border p-2 rounded w-full">
    </div>

</div>

<div class="mt-6">
    <button class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-2 rounded">
        Simpan Data
    </button>
</div>

</form>

<script>
function isiNamaBarang() {
    let select = document.getElementById("kode_hs");
    let selectedOption = select.options[select.selectedIndex];
    let nama = selectedOption.getAttribute("data-nama");
    document.getElementById("nama_barang").value = nama ?? '';
}
</script>

</div>

@endsection
