<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Penjualan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    public function index()
    {
        $obat = Obat::all();
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
        dd($request->all());
    }
}
