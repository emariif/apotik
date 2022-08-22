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
            // "diskon" => $request->diskon,
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
        $data = Penjualan::with('obats', 'pasiens', 'stock_obats', 'users')->where('nota', $nota)->latest();
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
}