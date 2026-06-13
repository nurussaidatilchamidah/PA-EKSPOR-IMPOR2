<style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 0.3;
                transform: scale(1);
            }
            50% {
                opacity: 0.5;
                transform: scale(1.05);
            }
        }
        
        .floating-shape {
            position: fixed;
            border-radius: 50%;
            opacity: 0.5;
            filter: blur(80px);
            z-index: 0;
            animation: pulse 4s ease-in-out infinite;
        }
        
        .content-wrapper {
            position: relative;
            z-index: 10;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
        }
        
        .stat-card {
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }
        
        .chart-card {
            animation: fadeInUp 0.8s ease-out;
        }
        
        .insight-card {
            animation: fadeInUp 1s ease-out;
        }
        
        .navbar-custom {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .delay-200 {
            animation-delay: 0.2s;
        }
        
        .delay-400 {
            animation-delay: 0.4s;
        }

        .badge {
    transition: 0.3s;
}
        .badge:hover {
    transform: scale(1.1);
}
.table {
    border-radius: 12px;
    overflow: hidden;
}
#tabelData {
    width: 100% !important;
}
#tabelData thead {
    background: linear-gradient(135deg, #4A6FA5, #166088);
    color: white;
}

#tabelData tbody tr {
    transition: 0.2s;
}

#tabelData tbody tr:hover {
    background-color: rgba(0,0,0,0.03);
}

.card.glass-card {
    border-radius: 20px;
    padding: 25px;
}

#tabelData thead th {
    text-align: center !important;
    vertical-align: middle;
}

.dataTables_wrapper .dataTables_info {
    text-align: center;
    margin-top: 10px;
}

.dataTables_wrapper .dataTables_paginate {
    margin-top: 10px;
    text-align: center;
}
.dataTables_length,
.dataTables_filter,
.dataTables_info {
    display: none !important;
}

.btn-export {
    border-radius: 4px;
    padding: 6px 14px;
    font-size: 10px;
    font-weight: 500;
    border: none;
    backdrop-filter: blur(6px);
    transition: all 0.25s ease;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* PNG */
.btn-png {
    background: linear-gradient(135deg, #4A6FA5, #166088);
    color: white;
}

/* PDF */
.btn-pdf {
    background: linear-gradient(135deg, #dc3545, #a71d2a);
    color: white;
}

.btn-csv {
    background: linear-gradient(135deg, #198754, #157347);
    color: #fff;
    border: none;
}

.btn-csv:hover {
    background: linear-gradient(135deg, #157347, #146c43);
    color: #fff;
}

/* HOVER */
.btn-export:hover {
    transform: translateY(-2px) scale(1.03);
    box-shadow: 0 8px 18px rgba(0,0,0,0.2);
    opacity: 0.95;
}

.pie-chart-wrapper {
    position: relative;
    width: min(100%, 520px);
    max-width: 520px;
    height: 520px;
    margin: 0 auto;
}

.pie-chart-wrapper canvas {
    width: 100% !important;
    height: 100% !important;
    display: block;
}

.pie-legend {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 0.75rem;
    margin-top: 1rem;
    max-height: 220px;
    overflow-y: auto;
    padding: 0.25rem 0;
}

.pie-legend .legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    min-width: 160px;
    font-size: 0.9rem;
    line-height: 1.3;
    color: #2c3e50;
}

.pie-legend .legend-color-box {
    width: 14px;
    height: 14px;
    border-radius: 3px;
    flex-shrink: 0;
}

@media (max-width: 767px) {
    .pie-chart-wrapper {
        height: 480px;
    }
}
</style>

<section id="dashboard" style="margin-top: 30px; padding-top: 30px; padding-bottom: 80px;">

<!-- Floating Shapes Background -->
    <div class="floating-shape bg-primary" style="width: 400px; height: 400px; top: -100px; left: -100px;"></div>
    <div class="floating-shape bg-info" style="width: 350px; height: 350px; bottom: -100px; right: -100px; animation-delay: 2s;"></div>
    <div class="floating-shape bg-primary" style="width: 300px; height: 300px; top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: 4s;"></div>

    <!-- Content -->
    <div class="container content-wrapper mt-4">

        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="text-white fw-bold mb-2" style="font-size: 3rem; text-shadow: 0 4px 20px rgba(0,0,0,0.3);">
                Dashboard Visualisasi Data Ekspor-Impor
            </h1>
            <p class="text-white opacity-75 fs-5">
                Data terkini dari Badan Pusat Statistik Indonesia
            </p>
        </div>

        {{-- CARD RINGKASAN --}}
        <div class="row mb-4 g-4">

            <div class="col-md-4">
                <div class="card stat-card shadow border-0 rounded-4 p-4 text-white h-100" style="background: linear-gradient(135deg, #4A6FA5, #166088);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 opacity-75">Total Ekspor</h6>
                        <div class="fs-3">📤</div>
                    </div>
            <h2 class="mb-0 fw-bold text-break">$ {{ number_format($total_ekspor, 2, '.', ',') }}</h2>                    
            <small class="opacity-75 mt-2">Nilai total ekspor nasional</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card delay-200 shadow border-0 rounded-4 p-4 text-white h-100" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 opacity-75">Total Impor</h6>
                        <div class="fs-3">📥</div>
                    </div>
                    <h2 class="mb-0 fw-bold text-break">$ {{ number_format($total_impor, 2, '.', ',') }}</h2>
                    <small class="opacity-75 mt-2">Nilai total impor nasional</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card delay-400 shadow border-0 rounded-4 p-4 text-white h-100" style="background: linear-gradient(135deg, #198754, #157347);">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="mb-0 opacity-75">Neraca Perdagangan</h6>
                        <div class="fs-3">💰</div>
                    </div>
                    <h2 class="mb-0 fw-bold text-break">$ {{ number_format($selisih, 2, '.', ',') }}</h2>
                    <small class="opacity-75 mt-2">
                        @if($selisih > 0)
                            Surplus Perdagangan ✅
                        @else
                            Defisit Perdagangan ⚠️
                        @endif
                    </small>
                </div>
            </div>

        </div>
        <div class="text-center mt-2 mb-4">
            <small class="text-white opacity-75">
                *Seluruh nilai ditampilkan dalam USD (United States Dollar)
            </small>
        </div>

{{-- GRAFIK EKSPOR IMPOR --}}
<div id="card-ekspor-impor" class="card glass-card chart-card shadow border-0 rounded-4 p-4 mb-4">

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>
            <h4 class="mb-1 fw-bold text-dark">
                📊 Grafik Ekspor-Impor & Prediksi ARIMA
            </h4>
            <p class="text-muted mb-0 small">
                Menampilkan data historis ekspor dan impor (garis solid), 
                serta hasil prediksi menggunakan metode ARIMA 
                (garis putus-putus) untuk tiga periode berikutnya. 
                Metode ARIMA (AutoRegressive Integrated Moving Average) digunakan untuk 
                memprediksi nilai berdasarkan pola data masa lalu.     
            </p>
        </div>

        <div class="d-flex gap-2">
            <button onclick="exportChartPNG('chartEksporImpor')" 
                class="btn btn-export btn-png">
                📷 PNG
            </button>

        <button onclick="exportChartPDF('chartEksporImpor', 'Grafik Ekspor Impor')" 
            class="btn btn-export btn-pdf">
            📄 PDF
        </button>
        </div>

    </div>
    <canvas id="chartEksporImpor" style="max-height: 400px;"></canvas>

    {{-- METRIK (DI DALAM CARD, CLEAN BAWAH) --}}
    <hr class="my-3">

    <div class="row text-center g-3">

        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-primary-subtle">
                <small class="text-muted">MAPE ARIMA Ekspor</small>
                <h5 class="fw-bold mb-0">
                    {{ number_format($mapeEkspor, 2) }}%
                </h5>
                <small>
                    @if($mapeEkspor < 10)
                        🟢 Sangat Baik
                    @elseif($mapeEkspor < 20)
                        🟡 Baik
                    @elseif($mapeEkspor < 50)
                        🟠 Cukup
                    @else
                        🔴 Kurang
                    @endif
                </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-danger-subtle">
                <small class="text-muted">MAPE ARIMA Impor</small>
                <h5 class="fw-bold mb-0">
                    {{ number_format($mapeImpor, 2) }}%
                </h5>
                <small>
                    @if($mapeImpor < 10)
                        🟢 Sangat Baik
                    @elseif($mapeImpor < 20)
                        🟡 Baik
                    @elseif($mapeImpor < 50)
                        🟠 Cukup
                    @else
                        🔴 Kurang
                    @endif
                </small>
            </div>
        </div>

    </div>

    {{-- NOTE --}}
    <div class="text-center mt-3">
        <small class="text-muted">
            Semakin kecil nilai MAPE (Mean Absolute Percentage Error), semakin akurat hasil prediksi ARIMA.
        </small>
    </div>

    </div>
    
    {{-- GRAFIK NERACA PERDAGANGAN --}}
        <div id="card-neraca" class="card glass-card shadow border-0 rounded-4 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-start mb-4">

    <!-- KIRI -->
    <div>
        <h4 class="fw-bold text-dark mb-1">
            ⚖️ Analisis Neraca Perdagangan
        </h4>
        <p class="text-muted small mb-0">
            Perbandingan antara nilai ekspor dan impor untuk menentukan kondisi surplus atau defisit.
        </p>
    </div>

    <!-- KANAN -->
    <div class="d-flex gap-2">
        <button onclick="exportChartPNG('chartNeraca')" 
            class="btn btn-export btn-png">
            📷 PNG
        </button>

        <button onclick="exportChartPDF('chartNeraca', 'Grafik Neraca Perdagangan')" 
            class="btn btn-export btn-pdf">
            📄 PDF
        </button>
    </div>

    </div>

    <div class="mb-4">
        <canvas id="chartNeraca"></canvas>
    </div>

    <div class="row text-center mb-4">
        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-success-subtle">
                <h6 class="text-success">Periode Surplus</h6>
                <h4 class="fw-bold">
                    {{ $totalSurplus }}
                </h4>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 rounded-3 bg-danger-subtle">
                <h6 class="text-danger">Periode Defisit</h6>
                <h4 class="fw-bold">
                    {{ $totalDefisit }}
                </h4>
            </div>
        </div>
    </div>

    <!-- STATUS PERIODE -->
    <div class="mb-4">
        <h6 class="fw-bold text-dark mb-2">📅 Status per Periode</h6>

        <div class="d-flex flex-wrap gap-2">
            @foreach($neracaPeriode as $n)
                <span class="badge 
                    {{ $n['selisih'] > 0 ? 'bg-success' : 'bg-danger' }}">
                    {{ $n['tanggal'] }} - {{ $n['status'] }}
                </span>
            @endforeach
        </div>
    </div>

    <!-- INTERPRETASI -->
    <div class="bg-light rounded-3 p-3">
        <p class="small text-dark mb-1">
            <strong>📌 Interpretasi:</strong>
        </p>
        <p class="small text-muted mb-0">
            Neraca perdagangan menunjukkan selisih antara ekspor dan impor. Surplus terjadi saat ekspor 
            lebih besar dari impor, sedangkan Defisit terjadi saat impor lebih besar dari ekspor.
        </p>
    </div>
</div>

    {{-- GRAFIK TOP KOMODITAS --}}
   <div id="card-komoditas" class="card glass-card shadow border-0 rounded-4 p-4 mb-4">
    <div class="d-flex justify-content-between align-items-start mb-3">

        <!-- KIRI -->
        <div>
            <h5 class="fw-bold text-dark mb-1">
                📦 Kontribusi Komoditas Ekspor vs Impor
            </h5>
            <p class="text-muted small mb-0">
            Menampilkan distribusi kontribusi komoditas ekspor dan impor 
            yang dapat dianalisis dalam tampilan Top 10 maupun seluruh komoditas.            
            </p>
        </div>

    <div class="d-flex gap-2">
    <button onclick="exportKomoditasPNG()" 
        class="btn btn-export btn-png">
        📷 PNG
    </button>

    <button onclick="exportKomoditasPDF()" 
        class="btn btn-export btn-pdf">
        📄 PDF
    </button>
    </div>

    </div>
    
    <div class="row">
        <!-- EKSPOR -->
        <div class="col-md-6 text-center">
            <h5 class="fw-bold text-primary">Ekspor</h5>
            <div class="btn-group btn-group-sm mb-3" role="group">
                <button id="eksporTop10Btn" type="button" class="btn btn-outline-primary active">Top 10</button>
                <button id="eksporAllBtn" type="button" class="btn btn-outline-primary">Semua</button>
            </div>
            <div class="pie-chart-wrapper mx-auto">
                <canvas id="chartEksporKomoditas"></canvas>
            </div>
            <div id="legendEkspor" class="pie-legend"></div>
        </div>

        <!-- IMPOR -->
        <div class="col-md-6 text-center">
            <h5 class="fw-bold text-danger">Impor</h5>
            <div class="btn-group btn-group-sm mb-3" role="group">
                <button id="imporTop10Btn" type="button" class="btn btn-outline-danger active">Top 10</button>
                <button id="imporAllBtn" type="button" class="btn btn-outline-danger">Semua</button>
            </div>
            <div class="pie-chart-wrapper mx-auto">
                <canvas id="chartImporKomoditas"></canvas>
            </div>
            <div id="legendImpor" class="pie-legend"></div>
        </div>
    </div>
        <!-- INTERPRETASI -->
    <div class="bg-light rounded-3 p-3">
        <p class="small text-dark mb-1">
            <strong>📌 Interpretasi:</strong>
        </p>
        <p class="small text-muted mb-0">   
        Diagram memperlihatkan kontribusi komoditas utama berdasarkan kode HS (Harmonized System). 
        Komoditas dengan proporsi terbesar merupakan penyumbang utama nilai ekspor maupun impor. Perbandingan 
        kedua diagram dapat digunakan untuk mengidentifikasi komoditas yang dominan pada ekspor, 
        impor, maupun keduanya. Nilai perdagangan ditampilkan dalam satuan USD (United States Dollar).   
     </p>
    </div>
    
    <!---CARD TOP KOMODITAS--->
    <div class="row g-3 mb-4">

    <div class="col-md-6">
        <div class="p-3 rounded-3 bg-primary-subtle text-center">

            <small class="text-primary fw-semibold">
                🏆 TOP EKSPOR
            </small>

            <div class="fw-bold mt-1">
                {{ Str::limit($komoditasEksporTerbesar->nama_barang, 40) }}
            </div>

            <small class="text-muted">
                USD {{ number_format($komoditasEksporTerbesar->total,0,',','.') }}
            </small>

        </div>
    </div>

    <div class="col-md-6">
        <div class="p-3 rounded-3 bg-danger-subtle text-center">

            <small class="text-danger fw-semibold">
                🏆 TOP IMPOR
            </small>

            <div class="fw-bold mt-1">
                {{ Str::limit($komoditasImporTerbesar->nama_barang, 40) }}
            </div>

            <small class="text-muted">
                USD {{ number_format($komoditasImporTerbesar->total,0,',','.') }}
            </small>

        </div>
    </div>

</div>

</div>
</div>

{{-- TABEL DATA --}}
<div class="container mt-4" style="max-width: 1150px;">

<div id="card-tabel" class="card glass-card shadow border-0 rounded-4 p-4 mb-4">

    <div class="d-flex justify-content-between align-items-start mb-3">

        <!-- KIRI -->
        <div>
            <h5 class="fw-bold text-dark mb-1">
                📋 Tabel Data Ekspor-Impor Bulanan
            </h5>
        </div>

        <!-- KANAN -->
        <div class="d-flex gap-2">
            <button onclick="exportTablePNG()" 
                class="btn btn-export btn-png">
                📷 PNG
            </button>

            <button onclick="exportTablePDF()" 
                class="btn btn-export btn-pdf">
                📄 PDF
            </button>

            <button onclick="exportCSV()" 
            class="btn btn-export btn-csv">
            📊 CSV
            </button>
        </div>

    </div>

    <!-- FILTER + SEARCH -->
    <div class="row g-2 mb-3">
        <div class="col-md-4">
            @php
                $uniqueBulan = $data->pluck('tanggal')
                    ->map(fn($t) => \Carbon\Carbon::parse($t)->translatedFormat('F Y'))
                    ->unique();
            @endphp
            <select id="filterBulan" class="form-select rounded-pill">
                <option value="">Semua Periode</option>
                @foreach($uniqueBulan as $bulan)
                    <option value="{{ $bulan }}">{{ $bulan }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" id="searchCustom"
                class="form-control rounded-pill"
                placeholder="🔍 Cari data...">
        </div>
    </div>

    <!-- TABLE (WAJIB DI DALAM CARD) -->
    <div class="table-responsive">
        <table id="tabelData" class="table table-hover align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>📅 Periode</th>
                    <th>📤 Ekspor (USD)</th>
                    <th>⚖️ Berat Ekspor (Kg)</th>
                    <th>📥 Impor (USD)</th>
                    <th>⚖️ Berat Impor (Kg)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td data-order="{{ $d->tanggal }}">
                        {{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('F Y') }}
                    </td>                    
                    <td class="text-primary fw-semibold">
                        $ {{ number_format($d->nilai_ekspor, 0, ',', '.') }}
                    </td>
                    <td>{{ number_format($d->berat_ekspor, 0, ',', '.') }}</td>
                    <td class="text-danger fw-semibold">
                        $ {{ number_format($d->nilai_impor, 0, ',', '.') }}
                    </td>
                    <td>{{ number_format($d->berat_impor, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- INSIGHT ANALISIS -->
<div id="card-insight" class="card border-0 shadow-sm rounded-4 p-4 mt-4 bg-white">

    <h5 class="fw-bold text-dark mb-2">
        📊 Insight Analisis Otomatis
    </h5>

    <p class="text-muted small mb-3">
        Ringkasan ini menjelaskan kondisi perdagangan Indonesia berdasarkan data ekspor dan impor.
    </p>

   <div class="row g-3">

    <!-- Total Perdagangan -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">📦 Total Perdagangan</div>

            <div class="fw-bold fs-5 text-dark">
                $ {{ number_format($insight['total_ekspor'] + $insight['total_impor']) }}
            </div>

            <small class="text-muted">
                Ekspor + Impor
            </small>
        </div>
    </div>

    <!-- Struktur -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">📊 Struktur Perdagangan</div>

            <div class="fw-bold">
                <span class="text-primary">
                    Ekspor {{ round($insight['kontribusi_ekspor'],2) }}%
                </span>
                |
                <span class="text-danger">
                    Impor {{ round($insight['kontribusi_impor'],2) }}%
                </span>
            </div>
            <small class="text-muted">
                Proporsi kontribusi terhadap total perdagangan     
            </small>
        </div>
    </div>

    <!-- Pertumbuhan -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">📈 Pertumbuhan</div>

            <div class="fw-bold fs-6">
                <span class="text-primary">
                    Ekspor {{ round($insight['growth_ekspor'],2) }}%
                </span>
                |
                <span class="text-danger">
                    Impor {{ round($insight['growth_impor'],2) }}%
                </span>
            </div>

            <small class="text-muted">
            Pertumbuhan dari awal hingga akhir periode
            </small>
        </div>
    </div>

    <!-- Puncak Ekspor -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">📤 Puncak Ekspor</div>

            <div class="fw-bold text-primary">
                {{ $insight['periode_ekspor_tertinggi'] }}
            </div>

            <small class="text-muted">
                $ {{ number_format($insight['nilai_ekspor_tertinggi']) }}
            </small>
        </div>
    </div>

    <!-- Puncak Impor -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">📥 Puncak Impor</div>

        <div class="fw-bold text-danger">
            {{ $insight['periode_impor_tertinggi'] }}
        </div>

        <small class="text-muted">
            $ {{ number_format($insight['nilai_impor_tertinggi']) }}
        </small>
        </div>
    </div>

    <!-- Akurasi -->
    <div class="col-md-4">
        <div class="p-3 border rounded-3 h-100 text-center">
            <div class="small text-muted mb-1">🎯 Akurasi Prediksi</div>

            <div class="fw-bold">
                <span class="text-primary">
                    Ekspor {{ number_format($mapeEkspor,2) }}%
                </span>
                |
                <span class="text-danger">
                    Impor {{ number_format($mapeImpor,2) }}%
                </span>
            </div>
        <small class="text-muted">
            Sangat Baik | Baik
        </small>
        </div>
    </div>
</div>
    <div class="p-3 bg-light rounded-3 mb-3 mt-4">
    <p class="text-dark mb-0" style="font-size: 14px; line-height:1.8;">
💡 Berdasarkan hasil analisis, perdagangan Indonesia berada dalam kondisi
{{ $insight['status'] }} dengan dominasi ekspor sebesar
{{ round($insight['kontribusi_ekspor'],2) }}% dari total perdagangan.

Ekspor tumbuh {{ round($insight['growth_ekspor'],2) }}%
dan impor tumbuh {{ round($insight['growth_impor'],2) }}% selama periode pengamatan.
Puncak ekspor terjadi pada {{ $insight['periode_ekspor_tertinggi'] }},
sedangkan puncak impor terjadi pada {{ $insight['periode_impor_tertinggi'] }}.

Model prediksi ARIMA memiliki akurasi yang baik
(MAPE ekspor {{ number_format($mapeEkspor,2) }}% dan MAPE impor {{ number_format($mapeImpor,2) }}%),
sehingga hasil prediksi dapat digunakan sebagai gambaran tren perdagangan pada periode berikutnya.
    </div>
</div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <script>
    const labels = @json($labels);
    const ekspor = @json($dataEkspor);
    const impor = @json($dataImpor);
    const prediksiEkspor = @json($dataPrediksiEkspor);
    const prediksiImpor = @json($dataPrediksiImpor);

    // Grafik Ekspor Impor
    new Chart(document.getElementById('chartEksporImpor'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Ekspor',
                    data: ekspor,
                    borderColor: '#4A6FA5',
                    backgroundColor: 'rgba(74, 111, 165, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#4A6FA5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Impor',
                    data: impor,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3,
                    pointBackgroundColor: '#dc3545',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Prediksi Ekspor (ARIMA)',
                    data: prediksiEkspor,
                    borderColor: '#ffc107',
                    borderDash: [6,6],
                    borderWidth: 3,
                    pointRadius: 0,
                    tension: 0.4
                },
                {
                    label: 'Prediksi Impor (ARIMA)',
                    data: prediksiImpor,
                    borderColor: '#20c997',
                    borderDash: [6,6],
                    borderWidth: 3,
                    pointRadius: 0,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    },
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                    label += '$ ' + context.parsed.y.toLocaleString('en-US');                            
                    return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return '$ ' + value.toLocaleString('en-US');
                        },
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Grafik Neraca Perdagangan
    const neraca = @json($neracaPeriode);

    new Chart(document.getElementById('chartNeraca'), {
    type: 'bar',
    data: {
        labels: neraca.map(n => n.tanggal),
        datasets: [{
            label: 'Selisih Ekspor - Impor',
            data: neraca.map(n => n.selisih),
            backgroundColor: neraca.map(n => 
                n.selisih > 0 ? '#198754' : '#dc3545'
            )
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let val = context.raw;
                        return (val > 0 ? 'Surplus: ' : 'Defisit: ') 
                               + '$ ' + val.toLocaleString();
                    }
                }
            }
        }
    }
});

// Grafik komoditas
const komoditasEksporTop = @json($topEkspor);
const komoditasImporTop = @json($topImpor);
const komoditasEksporAll = @json($allEkspor);
const komoditasImporAll = @json($allImpor);
const colorMap = getColorMap([...komoditasEksporAll, ...komoditasImporAll]);

function getColorMap(data) {
    const labels = [...new Set(data.map(d => d.nama_barang))];

    const baseColors = [
        '#4A6FA5','#166088','#4fc3f7','#81c3d7','#2f6690',
        '#6c757d','#20c997','#ffc107','#dc3545','#0d6efd',
        '#0dcaf0','#fd7e14','#6610f2','#20c997','#6f42c1'
    ];

    let colorMap = {};

    labels.forEach((label, index) => {
        colorMap[label] = baseColors[index % baseColors.length];
    });

    return colorMap;
}

function getPieOptions() {
    const isMobile = window.innerWidth < 768;
    return {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 1,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.parsed;
                        return label + ': $ ' + value.toLocaleString('en-US');
                    }
                }
            },
            datalabels: {
                color: function(context) {
                    const backgroundColor = context.dataset.backgroundColor[context.dataIndex];
                    return contrastColor(backgroundColor);
                },
                formatter: function(value, context) {
                    const data = context.chart.data.datasets[0].data;
                    const total = data.reduce((sum, item) => sum + Number(item), 0);
                    const current = Number(context.raw !== undefined ? context.raw : value);
                    const percentage = total > 0 ? (current / total) * 100 : 0;
                    return percentage.toFixed(1) + '%';
                },
                font: {
                    size: isMobile ? 10 : 12,
                    weight: '600'
                },
                anchor: 'center',
                clamp: true,
                clip: true
            }
        },
        layout: {
            padding: {
                top: 10,
                bottom: isMobile ? 70 : 60,
                left: 10,
                right: 10
            }
        }
    };
}

let chartEksporKomoditas;
let chartImporKomoditas;
let currentEksporData = komoditasEksporTop;
let currentImporData = komoditasImporTop;

function parseNumeric(value) {
    if (typeof value === 'number') return value;
    if (typeof value === 'string') {
        const cleaned = value.replace(/[^0-9.-]+/g, '');
        return cleaned ? Number(cleaned) : 0;
    }
    return 0;
}

function formatLegendItems(data) {
    const total = data.reduce((sum, item) => sum + parseNumeric(item.total), 0);
    return data.map(item => {
        const value = parseNumeric(item.total);
        const percentage = total > 0 ? ((value / total) * 100) : 0;
        return {
            label: item.nama_barang,
            value: value,
            percentage: percentage.toFixed(1),
            color: colorMap[item.nama_barang]
        };
    });
}

function contrastColor(bgColor) {
    const hex = bgColor.replace('#','');
    const r = parseInt(hex.substring(0,2), 16);
    const g = parseInt(hex.substring(2,4), 16);
    const b = parseInt(hex.substring(4,6), 16);
    const brightness = (r * 299 + g * 587 + b * 114) / 1000;
    return brightness > 140 ? '#111111' : '#ffffff';
}

function renderLegend(containerId, items) {
    const container = document.getElementById(containerId);
    if (!container) return;
    container.innerHTML = items.map(item => `
        <div class="legend-item">
            <div class="legend-color-box" style="background:${item.color}"></div>
            <div>${item.label} <strong>${item.percentage}%</strong></div>
        </div>
    `).join('');
}

function createPieChart(canvasId, data) {
    return new Chart(document.getElementById(canvasId), {
        type: 'pie',
        data: {
            labels: data.map(item => item.nama_barang),
            datasets: [{
                data: data.map(item => parseNumeric(item.total)),
                backgroundColor: data.map(item => colorMap[item.nama_barang]),
                borderColor: 'transparent',
                borderWidth: 0,
                hoverBorderWidth: 0
            }]
        },
        options: getPieOptions()
    });
}

function updatePieChart(chart, data) {
    chart.data.labels = data.map(item => item.nama_barang);
    chart.data.datasets[0].data = data.map(item => parseNumeric(item.total));
    chart.data.datasets[0].backgroundColor = data.map(item => colorMap[item.nama_barang]);
    chart.update();
}

function initKomoditasCharts() {console.log('Ekspor payload', currentEksporData);
console.log('Impor payload', currentImporData);    chartEksporKomoditas = createPieChart('chartEksporKomoditas', currentEksporData);
    chartImporKomoditas = createPieChart('chartImporKomoditas', currentImporData);
    renderLegend('legendEkspor', formatLegendItems(currentEksporData));
    renderLegend('legendImpor', formatLegendItems(currentImporData));

    function setActiveButton(group, activeBtnId) {
        document.querySelectorAll(group).forEach(btn => btn.classList.remove('active'));
        document.getElementById(activeBtnId).classList.add('active');
    }

    document.getElementById('eksporTop10Btn').addEventListener('click', function() {
        setActiveButton('#eksporTop10Btn, #eksporAllBtn', 'eksporTop10Btn');
        toggleEksporData(false);
    });
    document.getElementById('eksporAllBtn').addEventListener('click', function() {
        setActiveButton('#eksporTop10Btn, #eksporAllBtn', 'eksporAllBtn');
        toggleEksporData(true);
    });
    document.getElementById('imporTop10Btn').addEventListener('click', function() {
        setActiveButton('#imporTop10Btn, #imporAllBtn', 'imporTop10Btn');
        toggleImporData(false);
    });
    document.getElementById('imporAllBtn').addEventListener('click', function() {
        setActiveButton('#imporTop10Btn, #imporAllBtn', 'imporAllBtn');
        toggleImporData(true);
    });
}

document.addEventListener('DOMContentLoaded', initKomoditasCharts);

function toggleEksporData(showAll) {
    currentEksporData = showAll ? komoditasEksporAll : komoditasEksporTop;
    updatePieChart(chartEksporKomoditas, currentEksporData);
    renderLegend('legendEkspor', formatLegendItems(currentEksporData));
}

function toggleImporData(showAll) {
    currentImporData = showAll ? komoditasImporAll : komoditasImporTop;
    updatePieChart(chartImporKomoditas, currentImporData);
    renderLegend('legendImpor', formatLegendItems(currentImporData));
}

document.getElementById('eksporTop10Btn').addEventListener('click', function() {
    setActiveButton('#eksporTop10Btn, #eksporAllBtn', 'eksporTop10Btn');
    toggleEksporData(false);
});
document.getElementById('eksporAllBtn').addEventListener('click', function() {
    setActiveButton('#eksporTop10Btn, #eksporAllBtn', 'eksporAllBtn');
    toggleEksporData(true);
});
document.getElementById('imporTop10Btn').addEventListener('click', function() {
    setActiveButton('#imporTop10Btn, #imporAllBtn', 'imporTop10Btn');
    toggleImporData(false);
});
document.getElementById('imporAllBtn').addEventListener('click', function() {
    setActiveButton('#imporTop10Btn, #imporAllBtn', 'imporAllBtn');
    toggleImporData(true);
});

// DataTables
$(document).ready(function () {

    let table = $('#tabelData').DataTable({
        paging: false,
        info: false,
        lengthChange: false,
        searching: true, // WAJIB TRUE biar bisa dipakai custom search
        ordering: true,
        responsive: true
    });

    // SEARCH CUSTOM
    $('#searchCustom').on('keyup', function () {
        table.search(this.value).draw();
    });

    // FILTER BULAN (kolom 0 = tanggal)
    $('#filterBulan').on('change', function () {
        table.column(0).search(this.value).draw();
    });

});


// EKSPOR SPARKLINE
new Chart(document.getElementById('sparkEkspor'), {
    type: 'line',
    data: {
        labels: eksporData.map((_, i) => i + 1),
        datasets: [{
            data: eksporData,
            borderColor: '#22c55e',
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { display: false },
            y: { display: false }
        }
    }
});

// IMPOR SPARKLINE
new Chart(document.getElementById('sparkImpor'), {
    type: 'line',
    data: {
        labels: imporData.map((_, i) => i + 1),
        datasets: [{
            data: imporData,
            borderColor: '#ef4444',
            borderWidth: 2,
            tension: 0.4,
            pointRadius: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            x: { display: false },
            y: { display: false }
        }
    }
});

// export png
function exportChartPNG(chartId) {
    const chart = Chart.getChart(chartId);
    if (!chart) return alert("Chart tidak ditemukan!");

    // Simpan rasio asli
    const originalRatio = chart.options.devicePixelRatio || window.devicePixelRatio;

    // Paksa Chart.js merender ulang dengan resolusi 3x lebih tajam
    chart.options.devicePixelRatio = 3;
    
    // Update chart tanpa animasi agar instan
    chart.update('none');

    // Ambil gambar kualitas tinggi langsung dari method bawaan Chart.js
    const imgData = chart.toBase64Image('image/png', 1.0);

    // Proses Download
    const link = document.createElement('a');
    link.href = imgData;
    link.download = chartId + '.png';
    link.click();

    // Kembalikan chart ke resolusi normal
    chart.options.devicePixelRatio = originalRatio;
    chart.update('none');
}

// export pdf
async function exportChartPDF(chartId, title = "Grafik") {
    const { jsPDF } = window.jspdf;

    const originalChart = Chart.getChart(chartId);
    if (!originalChart) return alert("Chart tidak ditemukan!");

    const config = originalChart.config;

    // Buat canvas sementara (ukurannya proporsional saja)
    const canvas = document.createElement('canvas');
    canvas.width = 1000;
    canvas.height = 400;
    const ctx = canvas.getContext('2d');
    
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // Render chart baru (HD)
    const tempChart = new Chart(ctx, {
        type: config.type,
        data: config.data,
        options: {
            ...config.options,
            devicePixelRatio: 3, // KUNCI UTAMA AGAR PDF TAJAM
            responsive: false,
            animation: false, // Matikan animasi
            plugins: {
                ...config.options?.plugins,
                legend: { labels: { color: "#000" } }
            },
            scales: {
                x: { ticks: { color: "#000" } },
                y: { ticks: { color: "#000" } }
            }
        }
    });

    // Tunggu sebentar agar render Chart.js sempurna
    await new Promise(res => setTimeout(res, 300));

    // Ambil base64
    const imgData = tempChart.toBase64Image("image/png", 1.0);

    // Buat PDF
    const pdf = new jsPDF('landscape', 'mm', 'a4');
    pdf.setFontSize(14);
    pdf.text(title, 10, 10);
    pdf.addImage(imgData, 'PNG', 10, 20, 270, 130);
    pdf.save(chartId + '.pdf');

    // PENTING: Hapus chart sementara agar memori browser tidak bocor
    tempChart.destroy();
}

// ===== KOMODITAS EKSPOR-IMPOR (GABUNG) =====
async function generateKomoditasImage() {
    const chartEkspor = Chart.getChart('chartEksporKomoditas');
    const chartImpor = Chart.getChart('chartImporKomoditas');

    if (!chartEkspor || !chartImpor) {
        alert("Salah satu atau kedua chart tidak ditemukan!");
        return null;
    }

    // FUNGSI BANTU: Render ulang chart ke canvas sementara beresolusi tinggi (HD)
    async function getHDChartBase64(originalChart) {
        const config = originalChart.config;
        
        const tempCanvas = document.createElement('canvas');
        // Buat ukuran dasar yang besar (misal: 1200x600) agar vektor/teks dirender tajam
        tempCanvas.width = 1200;
        tempCanvas.height = 600;
        const ctx = tempCanvas.getContext('2d');
        
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(0, 0, tempCanvas.width, tempCanvas.height);

        const tempChart = new Chart(ctx, {
            type: config.type,
            data: config.data,
            options: {
                ...config.options,
                devicePixelRatio: 3, // KUNCI UTAMA HD
                responsive: false,
                animation: false,
                plugins: {
                    ...config.options?.plugins,
                    legend: { labels: { color: "#000" } }
                }
            }
        });

        // Tunggu sebentar agar Chart.js selesai menggambar di canvas baru
        await new Promise(res => setTimeout(res, 500));
        
        const base64 = tempChart.toBase64Image('image/png', 1.0);
        
        // Hapus chart sementara agar memori tidak bocor
        tempChart.destroy(); 
        
        return base64;
    }

    // 1. Dapatkan gambar HD sejati dari kedua chart
    const base64Ekspor = await getHDChartBase64(chartEkspor);
    const base64Impor = await getHDChartBase64(chartImpor);

    // 2. Load ke dalam object Image
    const imgEkspor = new Image();
    imgEkspor.src = base64Ekspor;

    const imgImpor = new Image();
    imgImpor.src = base64Impor;

    await Promise.all([
        new Promise(res => imgEkspor.onload = res),
        new Promise(res => imgImpor.onload = res)
    ]);

    // 3. Buat Canvas Gabungan (Raksasa)
    const finalCanvas = document.createElement('canvas');
    const ctxFinal = finalCanvas.getContext('2d');

    // Karena ukuran chart dari getHDChartBase64 adalah 1200x600, 
    // canvas penampung juga harus menyesuaikan ukurannya.
    const width = 1200; 
    const height = 600;
    const headerHeight = 120; // Ruang untuk judul

    finalCanvas.width = width * 2; // Kiri kanan (2400)
    finalCanvas.height = height + headerHeight; // (720)

    // Background putih
    ctxFinal.fillStyle = "#ffffff";
    ctxFinal.fillRect(0, 0, finalCanvas.width, finalCanvas.height);

    // Judul (Font diperbesar agar proporsional dengan canvas raksasa)
    ctxFinal.fillStyle = "#000";
    ctxFinal.font = "bold 48px Arial"; 
    ctxFinal.fillText("Kontribusi Komoditas Ekspor vs Impor", 40, 70);

    // Gambar Chart Ekspor (Kiri) & Impor (Kanan)
    ctxFinal.drawImage(imgEkspor, 0, headerHeight, width, height);
    ctxFinal.drawImage(imgImpor, width, headerHeight, width, height);

    return finalCanvas.toDataURL("image/png", 1.0);
}

// ===== PNG =====
async function exportKomoditasPNG() {
    const img = await generateKomoditasImage();

    const link = document.createElement('a');
    link.href = img;
    link.download = "komoditas-ekspor-impor.png";
    link.click();
}

// ===== PDF =====
async function exportKomoditasPDF() {
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('landscape');

    const img = await generateKomoditasImage();

    pdf.addImage(img, 'PNG', 10, 10, 270, 130);
    pdf.save("komoditas-ekspor-impor.pdf");
}

// ===== TABEL PNG =====
function exportTablePNG() {
    const table = document.getElementById('card-tabel');

    html2canvas(table, {
        scale: 3, // Disamakan dengan PDF agar sama-sama super HD
        useCORS: true,
        backgroundColor: "#ffffff" // Pastikan background tidak transparan
    }).then(canvas => {
        const link = document.createElement('a');
        link.download = 'tabel-ekspor-impor.png';
        // Tambahkan kualitas 1.0 agar tidak ada kompresi tambahan
        link.href = canvas.toDataURL("image/png", 1.0); 
        link.click();
    });
}

// ===== TABEL PDF =====
async function exportTablePDF() {
    const { jsPDF } = window.jspdf;
    const element = document.getElementById('card-tabel');

    const canvas = await html2canvas(element, {
        scale: 3, 
        useCORS: true,
        backgroundColor: "#ffffff"
    });

    const imgData = canvas.toDataURL("image/png", 1.0);
    const pdf = new jsPDF('landscape', 'mm', 'a4');

    const pageWidth = pdf.internal.pageSize.getWidth();
    const pageHeight = pdf.internal.pageSize.getHeight();

    // Margin kiri-kanan 10mm -> total margin 20mm
    const margin = 10;
    let imgWidth = pageWidth - (margin * 2);
    let imgHeight = (canvas.height * imgWidth) / canvas.width;

    pdf.setFontSize(14);
    pdf.text("Data Ekspor-Impor Bulanan", margin, margin + 5);

    // KUNCI: Cek apakah tinggi gambar melebihi kertas (margin atas 20, bawah 10 = sisa 30)
    const maxImgHeight = pageHeight - 30;

    if (imgHeight > maxImgHeight) {
        // Jika kepanjangan, kompres proporsinya agar tetap muat di 1 halaman
        imgHeight = maxImgHeight;
        imgWidth = (canvas.width * imgHeight) / canvas.height;
        
        // Posisikan di tengah secara horizontal agar rapi
        const xOffset = (pageWidth - imgWidth) / 2;
        pdf.addImage(imgData, 'PNG', xOffset, 20, imgWidth, imgHeight);
    } else {
        pdf.addImage(imgData, 'PNG', margin, 20, imgWidth, imgHeight);
    }

    pdf.save("tabel-ekspor-impor.pdf");
}
// ===== EXPORT CSV =====
function exportCSV() {
    let csv = [];
    let rows = document.querySelectorAll("#tabelData tr");

    for (let row of rows) {
        let cols = row.querySelectorAll("td, th");
        let data = [];

        cols.forEach(col => {
            // 1. Ambil teks dan hilangkan spasi kosong di awal/akhir
            let text = col.innerText.trim();
            
            // 2. Escape tanda kutip yang sudah ada di dalam teks (ubah " jadi "")
            text = text.replace(/"/g, '""');
            
            // 3. Bungkus seluruh teks dengan tanda kutip ganda ("1,250,000")
            data.push('"' + text + '"');
        });
        
        csv.push(data.join(","));
    }

    // Tambahkan BOM (\ufeff) agar Excel membaca karakter khusus (UTF-8) dengan benar
    let blob = new Blob(["\ufeff" + csv.join("\n")], { type: "text/csv;charset=utf-8;" });
    let url = window.URL.createObjectURL(blob);

    let a = document.createElement("a");
    a.href = url;
    a.download = "tabel-ekspor-impor.csv";
    a.click();
    
    // Cleanup URL untuk mencegah memory leak
    window.URL.revokeObjectURL(url);
}
</script>
</section>
