@php use Illuminate\Support\Str; @endphp

@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<!-- ===================== CARD RINGKASAN ===================== -->
<div class="grid grid-cols-4 gap-6 mb-8">

<div class="bg-green-600 text-white p-6 rounded-xl shadow-lg">
    <h2 class="text-sm uppercase tracking-wide">Total Ekspor</h2>
    <p class="text-2xl font-bold mt-2">
        $ {{ number_format($totalEkspor,0,',','.') }}
    </p>
    <p class="text-xs mt-2 text-green-100">
        Akumulasi nilai ekspor dari seluruh data bulanan
    </p>
</div>

<div class="bg-red-600 text-white p-6 rounded-xl shadow-lg">
    <h2 class="text-sm uppercase tracking-wide">Total Impor</h2>
    <p class="text-2xl font-bold mt-2">
        $ {{ number_format($totalImpor,0,',','.') }}
    </p>
    <p class="text-xs mt-2 text-red-100">
        Total nilai impor berdasarkan data bulanan 
    </p>
</div>

<div class="bg-blue-600 text-white p-6 rounded-xl shadow-lg">
    <h2 class="text-sm uppercase tracking-wide">
    {{ $selisih >= 0 ? 'Surplus' : 'Defisit' }}
</h2>

<p class="text-2xl font-bold mt-2">
    $ {{ number_format(abs($selisih),0,',','.') }}
</p>

<p class="text-xs mt-2 text-blue-100">
    Selisih antara ekspor dan impor (Ekspor - Impor)
</p>
</div>

<div class="bg-gray-800 text-white p-6 rounded-xl shadow-lg">
    <h2 class="text-sm uppercase tracking-wide">Total Record</h2>
    <p class="text-lg font-semibold mt-2">
        Bulanan: {{ $totalDataBulanan }} <br>
        HS: {{ $totalDataHS }}
    </p>
    <p class="text-xs mt-2 text-gray-300">
        Jumlah seluruh data yang tersimpan dalam sistem
    </p>
</div>

</div>


<!-- ===================== CHART AREA ===================== -->
<div class="space-y-8">

    <!-- LINE CHART -->
        <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold mb-4">
            Grafik Ekspor & Impor 
        </h2>
        <p class="text-sm text-gray-500 mb-2">
        Menampilkan nilai ekspor dan impor per bulan berdasarkan data bulanan terbaru yang diinputkan
        </p>

        <div id="chartBulanan"></div>
    </div>

    <!-- TREEMAP -->
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h2 class="text-lg font-bold mb-4">
            Treemap Komoditas Ekspor (Top 10)
        </h2>
        <p class="text-sm text-gray-500 mb-2">
        Menampilkan 10 komoditas dengan nilai ekspor tertinggi berdasarkan Kode HS 2 Digit

        <div id="chartHs"></div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // ================= LINE CHART =================
    var optionsBulanan = {
        chart: {
            type: 'line',
            height: 400
        },
        series: [
            {
                name: 'Ekspor',
                data: @json($ekspor)
            },
            {
                name: 'Impor',
                data: @json($impor)
            }
        ],
        xaxis: {
            categories: @json($labels)
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value.toLocaleString('id-ID');
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "USD " + val.toLocaleString('id-ID');
                }
            }
        }
    };

    var chartBulanan = new ApexCharts(
        document.querySelector("#chartBulanan"),
        optionsBulanan
    );
    chartBulanan.render();


    // ================= TREEMAP =================
    var optionsHs = {
        chart: {
            type: 'treemap',
            height: 600
        },

        legend: { show: false },

        plotOptions: {
            treemap: {
                distributed: true,
                enableShades: false
            }
        },

        dataLabels: {
            enabled: true,
            style: {
                fontSize: '14px',
                fontWeight: '700',
                colors: ['#ffffff']
            },

            formatter: function (text, opts) {

                let item = opts.w.config.series[0].data[opts.dataPointIndex];

                if (item.y > 500000000) {
                    return "HS " + item.kode + "\n" + item.shortName;
                } else {
                    return "HS " + item.kode;
                }
            }
        },

        tooltip: {
            custom: function({ seriesIndex, dataPointIndex, w }) {

                let item = w.config.series[seriesIndex].data[dataPointIndex];

                return `
                    <div style="padding:10px">
                        <strong>HS ${item.kode} - ${item.fullName}</strong><br>
                        Nilai Ekspor: USD ${Number(item.y).toLocaleString('id-ID')}
                    </div>
                `;
            }
        },

        series: [{
            data: [
                @foreach($dataHs->take(10) as $hs)
                {
                    x: "HS {{ $hs->kode_hs }}",
                    y: {{ $hs->nilai_ekspor }},
                    kode: "{{ $hs->kode_hs }}",
                    shortName: "{{ Str::limit($hs->nama_barang,18) }}",
                    fullName: "{{ $hs->nama_barang }}"
                },
                @endforeach
            ]
        }]
    };

    var chartHs = new ApexCharts(
        document.querySelector("#chartHs"),
        optionsHs
    );

    chartHs.render();

});
</script>


@endsection
