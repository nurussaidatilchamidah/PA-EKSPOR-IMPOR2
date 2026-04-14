<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Visualisasi Ekspor-Impor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
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
        
        body {
            background: linear-gradient(-45deg, #2f6690, #3a7ca5, #16425b, #81c3d7);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
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

</style>
</head>
<body>

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
        <div class="card glass-card chart-card shadow border-0 rounded-4 p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-1 fw-bold text-dark">📊 Grafik Ekspor-Impor & Prediksi ARIMA</h4>
                    <p class="text-muted mb-0 small">Menampilkan data historis ekspor dan impor (garis solid), 
                    serta hasil prediksi menggunakan metode <strong>ARIMA</strong> (garis putus-putus) untuk memperkirakan tren pada periode berikutnya.</p>
                </div>
            </div>
            <canvas id="chartEksporImpor" style="max-height: 400px;"></canvas>
        </div>

    {{-- GRAFIK NERACA PERDAGANGAN --}}
        <div class="card glass-card shadow border-0 rounded-4 p-4 mb-4">
        <div class="mb-4">
        <h4 class="fw-bold text-dark mb-1">⚖️ Analisis Neraca Perdagangan</h4>
        <p class="text-muted small mb-0">
            Perbandingan antara nilai ekspor dan impor untuk menentukan kondisi surplus atau defisit
        </p>
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
            Neraca perdagangan menunjukkan selisih antara ekspor dan impor. 
            <strong>Surplus</strong> terjadi saat ekspor lebih besar dari impor, 
            sedangkan <strong>defisit</strong> terjadi saat impor lebih besar dari ekspor.
        </p>
    </div>
</div>

    {{-- GRAFIK TOP KOMODITAS --}}
    <div class="card glass-card shadow border-0 rounded-4 p-4 mb-4">
    <h5 class="fw-bold text-dark mb-3">📦 Kontribusi Komoditas Ekspor vs Impor</h5>

    <p class="text-muted small mb-4">
        Diagram menunjukkan 10 komoditas utama yang paling berkontribusi terhadap nilai ekspor dan impor.
    </p>

    <div class="row">
        <!-- EKSPOR -->
        <div class="col-md-6 text-center">
            <h5 class="fw-bold text-primary">Ekspor</h5>
            <canvas id="chartEksporKomoditas"></canvas>
        </div>

        <!-- IMPOR -->
        <div class="col-md-6 text-center">
            <h5 class="fw-bold text-danger">Impor</h5>
            <canvas id="chartImporKomoditas"></canvas>
        </div>
    </div>
        <!-- INTERPRETASI -->
    <div class="bg-light rounded-3 p-3">
        <p class="small text-dark mb-1">
            <strong>📌 Interpretasi:</strong>
        </p>
        <p class="small text-muted mb-0">
        Diagram menunjukkan kontribusi komoditas utama (berdasarkan kode HS) terhadap ekspor dan impor. 
        Warna yang sama menandakan komoditas yang sama, sehingga memudahkan perbandingan. 
        Semakin besar proporsi, semakin besar perannya dalam perdagangan.       
     </p>
    </div>
</div>
</div>

{{-- TABEL DATA --}}
<div class="container mt-4" style="max-width: 1150px;">

    <div class="card glass-card shadow border-0 rounded-4 p-4 mb-4">

    <h5 class="fw-bold text-dark mb-3">
        📋 Data Ekspor-Impor Bulanan
    </h5>

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
                    <th>⚖️ Berat Ekspor</th>
                    <th>📥 Impor (USD)</th>
                    <th>⚖️ Berat Impor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $d)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($d->tanggal)->translatedFormat('F Y') }}</td>
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

    <!-- INTERPRETASI -->
    <div class="bg-light rounded-3 p-3 mt-3">
        <p class="small text-muted mb-0">
            Tabel ini menampilkan data ekspor dan impor bulanan secara interaktif 
            dengan fitur pencarian dan filter periode.
        </p>
    </div>
</div>

<!-- INSIGHT ANALISIS -->
<div class="card border-0 shadow-sm rounded-4 p-4 mt-4 bg-white">

    <h5 class="fw-bold text-dark mb-2">
        📊 Insight Analisis Otomatis
    </h5>

    <p class="text-muted small mb-3">
        Ringkasan ini menjelaskan kondisi perdagangan Indonesia berdasarkan data ekspor dan impor.
    </p>

    <!-- NARASI UTAMA -->
    <div class="p-3 bg-light rounded-3 mb-3">
        <p class="text-dark small mb-0" style="line-height:1.8;">
            {!! $insight['narasi'] !!}
        </p>
    </div>

    <!-- PENJELASAN BAGIAN ANGKA -->
    <div class="row g-2">

        <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
                <small class="text-muted">📦 Total Perdagangan</small>
                <div class="fw-bold text-dark">
                    Rp {{ number_format($insight['total_ekspor'] + $insight['total_impor']) }}
                </div>
                <small class="text-muted">
                    Gabungan total ekspor + impor
                </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
                <small class="text-muted">⚖️ Selisih Perdagangan</small>
                <div class="fw-bold text-dark">
                    Rp {{ number_format($insight['selisih']) }}
                </div>
                <small class="text-muted">
                    Jika positif = surplus, jika negatif = defisit
                </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
                <small class="text-muted">📈 Pertumbuhan Ekspor</small>
                <div class="fw-bold text-dark">
                    {{ round($insight['growth'], 2) }}%
                </div>
                <small class="text-muted">
                    Perubahan dari awal ke akhir periode
                </small>
            </div>
        </div>

        <div class="col-md-6">
            <div class="p-3 border rounded-3 h-100">
                <small class="text-muted">📊 Status Perdagangan</small>
                <div class="fw-bold text-dark">
                    {{ $insight['status'] }}
                </div>
                <small class="text-muted">
                    Kondisi akhir neraca perdagangan
                </small>
            </div>
        </div>

    </div>

    <!-- POINTS (opsional tetap dipakai tapi lebih “simple”) -->
    <div class="mt-3">
        <div class="row g-2">

            @foreach($insight['points'] as $point)
            <div class="col-md-6">
                <div class="p-2 bg-white border rounded-3 small text-dark">
                    🔹 {{ $point }}
                </div>
            </div>
            @endforeach

        </div>
    </div>

</div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
const komoditasEkspor = @json($topEkspor);
const komoditasImpor = @json($topImpor);
const colorMap = getColorMap(komoditasEkspor, komoditasImpor);

function getColorMap(dataEkspor, dataImpor) {
    const allLabels = [...dataEkspor, ...dataImpor].map(d => d.nama_barang);
    const uniqueLabels = [...new Set(allLabels)];

    const baseColors = [
        '#4A6FA5','#166088','#4fc3f7','#81c3d7','#2f6690',
        '#6c757d','#20c997','#ffc107','#dc3545','#0d6efd'
    ];

    let colorMap = {};

    uniqueLabels.forEach((label, index) => {
        colorMap[label] = baseColors[index % baseColors.length];
    });

    return colorMap;
}

// PIE EKSPOR
new Chart(document.getElementById('chartEksporKomoditas'), {
    type: 'pie',
    data: {
        labels: komoditasEkspor.map(e => e.nama_barang),
        datasets: [{
            data: komoditasEkspor.map(e => e.total),
backgroundColor: komoditasEkspor.map(e => colorMap[e.nama_barang])        
    }]
    }
});

// PIE IMPOR
new Chart(document.getElementById('chartImporKomoditas'), {
    type: 'pie',
    data: {
        labels: komoditasImpor.map(i => i.nama_barang),
        datasets: [{
            data: komoditasImpor.map(i => i.total),
backgroundColor: komoditasImpor.map(i => colorMap[i.nama_barang])
        }]
    }
});

// DataTables
$(document).ready(function () {

    let table = $('#tabelData').DataTable({
        paging: true,
        info: false,
        lengthChange: false,
        searching: true // WAJIB TRUE biar bisa dipakai custom search
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

</script>
</section>
</body>
</html>