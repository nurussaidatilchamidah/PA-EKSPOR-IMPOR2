@extends('layouts.admin')

@section('title', 'Tambah Data Bulanan')

@section('content')

<div class="bg-white p-6 rounded-lg shadow-md">

    <form action="{{ route('admin.data.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label class="block mb-1 font-semibold">Tahun</label>
                <input type="number" name="tahun" 
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Bulan</label>
                <select name="bulan" 
                        class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Bulan --</option>
                    <option>Januari</option>
                    <option>Februari</option>
                    <option>Maret</option>
                    <option>April</option>
                    <option>Mei</option>
                    <option>Juni</option>
                    <option>Juli</option>
                    <option>Agustus</option>
                    <option>September</option>
                    <option>Oktober</option>
                    <option>November</option>
                    <option>Desember</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-semibold">Nilai Ekspor (USD)</label>
                <input type="text" name="nilai_ekspor"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Berat Ekspor (Kg)</label>
                <input type="text" name="berat_ekspor"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Nilai Impor (USD)</label>
                <input type="text" name="nilai_impor"
                       class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-semibold">Berat Impor (Kg)</label>
                <input type="text" name="berat_impor"
                       class="w-full border rounded px-3 py-2">
            </div>

        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-700 hover:bg-blue-500 text-white px-6 py-2 rounded-lg shadow">
                Simpan Data
            </button>
        </div>

    </form>

</div>

@endsection
