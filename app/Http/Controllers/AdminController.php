<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataEksporImpor;
use App\Models\DataHS;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Models\MasterHs;
use Carbon\Carbon;

class AdminController extends Controller
{

private function convertNumber($value)
{
    if ($value === null || $value === '') return 0;

    // Jika sudah numeric (dari Excel), langsung return
    if (is_numeric($value)) {
        return $value;
    }

    // Hapus spasi
    $value = trim($value);

    // Hapus semua titik ribuan
    $value = str_replace('.', '', $value);

    // Ubah koma jadi titik (desimal)
    $value = str_replace(',', '.', $value);

    return $value;
}

private function convertBulan($bulan)
{
    $bulan = strtolower(trim($bulan));

    $bulanList = [
        'januari' => '01',
        'februari' => '02',
        'maret' => '03',
        'april' => '04',
        'mei' => '05',
        'juni' => '06',
        'juli' => '07',
        'agustus' => '08',
        'september' => '09',
        'oktober' => '10',
        'november' => '11',
        'desember' => '12'
    ];

    return $bulanList[$bulan] ?? null;
}

       // DASHBOARD
public function dashboard()
{
$tahun = request('tahun');

// =============================
    // CARD SUMMARY
    // =============================
$totalEkspor = DataEksporImpor::sum('nilai_ekspor');
$totalImpor = DataEksporImpor::sum('nilai_impor');

$selisih = $totalEkspor - $totalImpor;

    $selisih = $totalEkspor - $totalImpor;

    $totalDataBulanan = DataEksporImpor::count();
    $totalDataHS = DataHs::count();


    // =============================
    // DATA LINE CHART BULANAN
    // =============================
$dataBulanan = DataEksporImpor::orderBy('tanggal')->get();


$labels = $dataBulanan->pluck('tanggal')->map(function($item){
        return Carbon::parse($item)->format('M Y');
});
    $ekspor = $dataBulanan->pluck('nilai_ekspor');
    $impor  = $dataBulanan->pluck('nilai_impor');


    // =============================
    // DATA TREEMAP HS
    // =============================
$dataHs = DB::table('data_hs')
    ->select('kode_hs','nama_barang','nilai_ekspor')
    ->orderByDesc('nilai_ekspor')
    ->get();

    return view('admin.data.dashboard', compact(
        'totalEkspor',
        'totalImpor',
        'selisih',
        'totalDataBulanan',
        'totalDataHS',
        'tahun',
        'labels',
        'ekspor',
        'impor',
        'dataHs'
    ));
}

    // INDEX BULANAN
    public function index()
{
$data = DataEksporImpor::orderBy('tanggal','desc')->get();

    return view('admin.data.index', compact('data'));
}

    // CREATE BULANAN
    public function create()
    {
        return view('admin.data.create');
    }

    // STORE (Manual Input)
public function store(Request $request)
{
    $request->validate([
        'tahun' => 'required',
        'bulan' => 'required',
        'nilai_ekspor' => 'required',
        'berat_ekspor' => 'required',
        'nilai_impor' => 'required',
        'berat_impor' => 'required',
    ]);

    // ubah bulan -> angka
    $bulan = $this->convertBulan($request->bulan);

    // buat tanggal
    $tanggal = $request->tahun . '-' . $bulan . '-01';

    $data = DataEksporImpor::create([
        'tanggal' => $tanggal,
        'nilai_ekspor' => $this->convertNumber($request->nilai_ekspor),
        'berat_ekspor' => $this->convertNumber($request->berat_ekspor),
        'nilai_impor' => $this->convertNumber($request->nilai_impor),
        'berat_impor' => $this->convertNumber($request->berat_impor),
    ]);

    return redirect()->route('admin.data')
        ->with('success', 'Data berhasil ditambahkan!')
        ->with('highlight_id', $data->id);
}

    // EDIT BULANAN
    public function edit($id)
    {
        $data = DataEksporImpor::findOrFail($id);
        return view('admin.data.edit', compact('data'));
    }

    // UPDATE BULANAN
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun' => 'required',
            'bulan' => 'required',
            'nilai_ekspor' => 'required',
            'berat_ekspor' => 'required',
            'nilai_impor' => 'required',
            'berat_impor' => 'required',
        ]);
        $data = DataEksporImpor::findOrFail($id);

        $data->update([
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'nilai_ekspor' => $this->convertNumber($request->nilai_ekspor),
            'berat_ekspor' => $this->convertNumber($request->berat_ekspor),
            'nilai_impor' => $this->convertNumber($request->nilai_impor),
            'berat_impor' => $this->convertNumber($request->berat_impor),
        ]);


        return redirect()->route('admin.data')
        ->with('update', 'Data Bulanan berhasil diperbarui!')
        ->with('highlight_id', $data->id);
    }

    // DELETE BULANAN
    public function destroy($id)
    {
        $data = DataEksporImpor::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.data')
            ->with('delete', 'Data berhasil dihapus!');
    }

// IMPORT BULANAN
public function importBulanan(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
        'tahun' => 'required'
    ]);

    $tahun = $request->tahun;

    $spreadsheet = IOFactory::load($request->file('file')->getPathname());
    $rows = $spreadsheet->getActiveSheet()->toArray();

    DB::beginTransaction();

    try {

        foreach ($rows as $row) {

    if (!isset($row[0])) continue;

    $bulanText = trim($row[0]);

    if (
        empty($bulanText) ||
        strtolower($bulanText) == 'bulan' ||
        strtolower($bulanText) == 'jumlah'
    ) {
        continue;
    }

    $bulan = $this->convertBulan($bulanText);

    if (!$bulan) continue;

    $tanggal = $tahun . '-' . $bulan . '-01';

    DataEksporImpor::updateOrCreate(
        [
            'tanggal' => $tanggal
        ],
        [
            'nilai_ekspor' => $this->convertNumber($row[1] ?? 0),
            'berat_ekspor' => $this->convertNumber($row[2] ?? 0),
            'nilai_impor'  => $this->convertNumber($row[3] ?? 0),
            'berat_impor'  => $this->convertNumber($row[4] ?? 0),
        ]
    );
}
        DB::commit();

        return redirect()->route('admin.data')
            ->with('success', 'Import data berhasil!');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', 'Gagal import: ' . $e->getMessage());
    }
}

// IMPORT HS
public function importHS(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $spreadsheet = IOFactory::load($request->file('file')->getPathname());
    $rows = $spreadsheet->getActiveSheet()->toArray();

DB::beginTransaction();

try {

if (count($rows) > 1) {
    DataHS::query()->delete();
}
    foreach ($rows as $index => $row) {

        if ($index == 0) continue;
        if (empty($row[0])) continue;

        $kodeDanNama = explode(' ', trim($row[0]), 2);
        $kode = str_replace(['[', ']'], '', $kodeDanNama[0]);
        $nama = $kodeDanNama[1] ?? '';

        DataHS::create([
            'kode_hs'      => $kode,
            'nama_barang'  => $nama,
            'nilai_ekspor' => $this->convertNumber($row[1] ?? 0),
            'berat_ekspor' => $this->convertNumber($row[2] ?? 0),
            'nilai_impor'  => $this->convertNumber($row[3] ?? 0),
            'berat_impor'  => $this->convertNumber($row[4] ?? 0),
        ]);
    }

    DB::commit();

    return back()->with('success', 'Data HS terbaru berhasil diimport!');

} catch (\Exception $e) {

    DB::rollBack();

    return back()->with('error', 'Gagal import HS: ' . $e->getMessage());
}
}

public function dataHS()
{
    $data = DataHS::orderBy('kode_hs', 'asc')->get();
    return view('admin.data.hs', compact('data'));
}

public function indexHS()
{
    $data = DataHS::orderBy('kode_hs', 'asc')->get();    
    return view('admin.data.hs', compact('dataHS'));
}

// CREATE HS
public function createHS()
{
    $masterHs = MasterHS::all();
    return view('admin.data.hs_create', compact('masterHs'));
}


// STORE HS
public function storeHS(Request $request)
{
    $request->validate([
        'kode_hs' => 'required',
        'nama_barang' => 'required',
        'nilai_ekspor' => 'required',
        'berat_ekspor' => 'required',
        'nilai_impor' => 'required',
        'berat_impor' => 'required',
    ]);

    $data = DataHS::create([
        'kode_hs'      => $request->kode_hs,
        'nama_barang'  => $request->nama_barang,
        'nilai_ekspor' => $this->convertNumber($request->nilai_ekspor),
        'berat_ekspor' => $this->convertNumber($request->berat_ekspor),
        'nilai_impor'  => $this->convertNumber($request->nilai_impor),
        'berat_impor'  => $this->convertNumber($request->berat_impor),
    ]);

    return redirect()->route('admin.data.hs')
        ->with('success', 'Data HS berhasil ditambahkan!')
        ->with('highlight_id', $data->id);
}

// EDIT HS
public function editHS($id)
{
    $data = DataHS::findOrFail($id);
    $masterHs = MasterHS::all();

    return view('admin.data.hs_edit', compact('data','masterHs'));
}


// UPDATE HS
public function updateHS(Request $request, $id)
{
    $data = DataHS::findOrFail($id);

    $data->update([
        'kode_hs'      => $request->kode_hs,
        'nama_barang'  => $request->nama_barang,
        'nilai_ekspor' => $this->convertNumber($request->nilai_ekspor),
        'berat_ekspor' => $this->convertNumber($request->berat_ekspor),
        'nilai_impor'  => $this->convertNumber($request->nilai_impor),
        'berat_impor'  => $this->convertNumber($request->berat_impor),
    ]);

    return redirect()->route('admin.data.hs')
        ->with('update', 'Data HS berhasil diperbarui!')
        ->with('highlight_id', $data->id);
}

// DELETE HS
public function destroyHS($id)
{
    $data = DataHS::findOrFail($id);
    $data->delete();

    return redirect()->route('admin.data.hs')
        ->with('delete', 'Data HS berhasil dihapus!');
}


}
