<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Pasien;
use App\Models\Penjualan;
use App\Models\stockObat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
// use Dompdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
use App;

class PenjualanController extends Controller
{
    public function index()
    {
        $obat = stockObat::all();
        $tanggals = Carbon::now()->format('Y-m-d');
        $now = Carbon::now();
        $thnBulan = $now->format('Ym'); //Year Month
        $cek = Penjualan::count(); //Cek jumlah data di tabel penjualan
        if ($cek == 0) { //Jika data kosong
            $urut = 10000001;
            $nomer = 'NT'. $thnBulan . $urut;
            // dd($nomer);
        }else{
            // echo 'ddas';
            $ambil = Penjualan::all()->last(); //Ambil data terakhir
            // $ambil = Penjualan::orderBy('id', 'desc')->first(); //Ambil data terakhir
            // $urut = $ambil->id + 1; //Ambil data terakhir + 1
            $urut = (int)substr($ambil->nota, -8) + 1; //Ambil data terakhir + 1
            $nomer = 'NT'. $thnBulan . $urut;
        }
        return view('owner.penjualan', compact('obat', 'tanggals', 'nomer'));
    }

    public function store(Request $request)
    {
        $rules = [
            "nama" => "required",
            "telp" => "required",
            "obat" => "required",
            "qty" => "required",
            "alamat" => "required"
        ];

        $text = [
            "nama.required" => "Nama harus diisi",
            "telp.required" => "Nomor Telpon harus diisi",
            "obat.required" => "Obat harus diisi",
            "qty.required" => "Jumlah harus diisi",
            "alamat.required" => "Alamat harus diisi"
        ];

        $validasi = Validator::make($request->all(), $rules, $text);
        
        if($validasi->fails()) {
            return response()->json(['success' => 0, 'text' => $validasi->errors()->first()], 422);
        }
        // dd($request->all());
        $pasien = [
            "nama" => $request->nama,
            "telp" => $request->telp,
            "alamat" => $request->alamat,
            "resep" => $request->no_resep,
            "pengirim" => $request->pengirim,
        ];  
        $consumer = Pasien::create($pasien);
        $idPasien = $consumer->id;
        $penjualan = [
            "nota" => $request->nota,
            // "status" => $request->status, //0 = belum bayar, 1 = sudah bayar
            "tanggal" => $request->tanggal,
            "qty" => $request->qty,
            // "pajak" => $request->pajak, //0 = non pajak, 1 = pajak
            "diskon" => $request->diskon,
            "subTotal" => $request->total, //lihat name di form
            "item" => $request->obat, //lihat name di form
            "consumer" => $idPasien,
            "kasir" => Auth::user()->id,
        ];

        $transaksi = Penjualan::create($penjualan);
        if ($transaksi) {
            $stock = stockObat::where('obat_id', $request->obat)->first();
            $stock->update(['stock' => $request->stock]); //request stock didapat dari form
            return response()->json(['text' => 'Pembelian Ditambahkan'], 200);
        } else {
            return response()->json(['text' => 'Pembelian Gagal Ditambahkan'], 422);
        }
    }
    
    public function dataTable(Request $request){
        $nota = $request->id;
        $data = Penjualan::with('obats', 'consumers', 'stock_obats', 'kasirs')->where('nota', $nota)->latest();
        // $data = Penjualan::all()->where('nota', $nota)->last();
        // if(request()->ajax()) {
        //     return dataTables()->of($data)
        //     ->addColumn('aksi', function($data)
        //     {
        //         $button = '<button class="hapus btn btn-danger" id="'.$data->id.'" name="hapus">Hapus</button>';
        //         return $button;
        //     })
        //     ->rawColumns(['aksi'])
        //     ->make(true);
        // }
        if(request()->ajax()) {
            return Datatables::eloquent($data)
            ->addColumn('item', function($data) {
                return $data->obats->nama;
            })
            ->addColumn('jual', function($data) {
                return $data->obats->stockObats->jual;
            })
            ->addColumn('aksi', function($data)
            {
                $button = '<button class="hapus btn btn-danger" id="'.$data->id.'" name="hapus">Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
    }

    // Fungsi Hapus Orderan
    public function hapus(Request $request){
        $id = $request->id;
        $hapusJual = Penjualan::find($id);

        // Melakukan Update terlebih dahulu sebelum penghapusan
        $stock = stockObat::where('obat_id', $hapusJual->item)->first(); //limit 1 (fitst)
        $tambah = $hapusJual->qty + $stock->stock; //Update hasil setelah dihapus
        $stock->update(['stock' => $tambah]); //Update stock (harus array =>)
        if ($stock) {
            $hapus = $hapusJual->delete();
            return response()->json(['text' => 'Data Berhasil Dikurangi'], 200);
        } else {
            return response()->json(['text' => 'Sistem Error'], 500);
        }
    }

    public function hitung(Request $request){
        $id = $request->id;
        $data = Penjualan::hitung($id)->get();
        $datas = Penjualan::where('nota', $id)->get();
        $discount = [];
        foreach ($datas as $key) {
            array_push($discount, ($key->diskon/100 * $key->subTotal)); //diskon yang didapat
        }
        $diskon = array_sum($discount); //total diskon 
        return response()->json(['data' => $data, 'diskon' => $diskon], 200);
    }

    public function cetakNota(Request $request){
        // dd($request->kwitansi);
        $nota = $request->kwitansi; 
        $data = Penjualan::joinCetak()
            // ->where('penjualans.nota', 'NT20220810000001')
            ->where('penjualans.nota', $nota)
            ->get();
        // $bruto = Penjualan::joinCetak()
        //     ->where('penjualans.nota', $nota)
        //     ->selectRaw('SUM(subTotal) as bruto')
        //     ->groupBy('penjualans.nota')
        //     ->get();
        $pdf = Pdf::loadView('owner.cetakNota', compact('data'));

        // dd($pdf);
        // $pdf = Pdf::loadView('owner.cetakNota', ['data' => $data, 'bruto' => $bruto]);

        return $pdf->stream('invoice.pdf');

    }

    public function download(Request $request){
        $nota = $request->kwitansi; 
        $pdf = PDF::loadView("owner.cetakNota", [$nota]);
        // return Pdf::loadFile(public_path().'images/file')->save('/path-to/my_stored_file.pdf')->stream('download.pdf');
        return $pdf->stream('invoice.pdf');


    }
}