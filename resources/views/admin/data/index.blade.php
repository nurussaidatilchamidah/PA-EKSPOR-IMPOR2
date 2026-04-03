@extends('layouts.admin')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="text-xl font-bold mb-6">Kelola Data Ekspor Impor Nasional Bulanan</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- CARD TAMBAH DATA -->
    <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
        <div>
            <h3 class="text-lg font-semibold mb-2">Input Data Manual</h3>
            <p class="text-gray-500 text-sm mb-4">
                Input data ekspor impor secara manual untuk bulan tertentu.
            </p>
        </div>

        <a href="{{ route('admin.data.create') }}"
           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-center transition">
            + Input Data
        </a>
    </div>


    <!-- CARD IMPORT DATA -->
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="text-lg font-semibold mb-2">Import Data Bulanan</h3>
        <div class="mb-3">
</div>
        <p class="text-gray-500 text-sm mb-4">
            Upload file Excel (.xlsx / .xls / .csv)
        </p>

        <form action="{{ route('import.bulanan') }}" 
              method="POST" 
              enctype="multipart/form-data"
              class="flex flex-col gap-3">

            @csrf

            <select name="tahun" required class="border p-2 rounded text-sm">
    <option value="">Pilih Tahun</option>
    <option value="2024">2024</option>
    <option value="2025">2025</option>
    <option value="2026">2026</option>
</select>


            <input type="file" 
                   name="file" 
                   required 
                   class="border p-2 rounded text-sm">

            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                Import Data
            </button>
        </form>
    </div>

</div>

<!-- NOTIFIKASI -->
 
{{-- SUCCESS --}}
@if(session('success'))
<div id="alert-success"
    class="mb-4 p-4 rounded-lg bg-green-100 border-l-4 border-green-600 text-green-800 shadow-md">
    <div class="flex justify-between items-center">
        <span>✅ {{ session('success') }}</span>
        <button onclick="document.getElementById('alert-success').remove()">✖</button>
    </div>
</div>
@endif

{{-- UPDATE --}}
@if(session('update'))
<div id="alert-update"
    class="mb-4 p-4 rounded-lg bg-blue-100 border-l-4 border-blue-600 text-blue-800 shadow-md">
    <div class="flex justify-between items-center">
        <span>✏️ {{ session('update') }}</span>
        <button onclick="document.getElementById('alert-update').remove()">✖</button>
    </div>
</div>
@endif

{{-- DELETE --}}
@if(session('delete'))
<div id="alert-delete"
    class="mb-4 p-4 rounded-lg bg-red-100 border-l-4 border-red-600 text-red-800 shadow-md">
    <div class="flex justify-between items-center">
        <span>🗑️ {{ session('delete') }}</span>
        <button onclick="document.getElementById('alert-delete').remove()">✖</button>
    </div>
</div>
@endif

{{-- ERROR --}}
@if(session('error'))
<div id="alert-error"
    class="mb-4 p-4 rounded-lg bg-yellow-100 border-l-4 border-yellow-600 text-yellow-800 shadow-md">
    <div class="flex justify-between items-center">
        <span>⚠️ {{ session('error') }}</span>
        <button onclick="document.getElementById('alert-error').remove()">✖</button>
    </div>
</div>
@endif

<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full border-collapse">
        <thead class="bg-blue-900 text-white">
            <tr>
                <th class="p-3">Tahun</th>
                <th class="p-3">Bulan</th>
                <th class="p-3">Nilai Ekspor (USD)</th>
                <th class="p-3">Berat Ekspor (Kg)</th>
                <th class="p-3">Nilai Impor (USD)</th>
                <th class="p-3">Berat Impor (Kg)</th>
                <th class="p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
<td class="p-3">{{ \Carbon\Carbon::parse($item->tanggal)->format('Y') }}</td>
<td class="p-3">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('F') }}</td>
                <td class="p-3">{{ number_format($item->nilai_ekspor,3,',','.') }}</td>
                <td class="p-3">{{ number_format($item->berat_ekspor,3,',','.') }}</td>
                <td class="p-3">{{ number_format($item->nilai_impor,3,',','.') }}</td>
                <td class="p-3">{{ number_format($item->berat_impor,3,',','.') }}</td>
                <td class="p-3 flex gap-2">
                    <a href="{{ route('admin.data.edit',$item->id) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                       Edit
                    </a>

                    <form id="delete-form-{{ $item->id }}"
                    action="{{ route('admin.data.delete',$item->id) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button"
                        onclick="confirmDelete({{ $item->id }})"
                        class="bg-red-600 text-white px-3 py-1 rounded">
                        Hapus
                    </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

        <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Yakin mau hapus?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        </script>

</div>

@endsection
