<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Support\Facades\Validator;

class ObatController extends Controller
{
    public function index()
    {
        // $data = Obat::all();
        $satuan = Satuan::all();
        $kategori = Kategori::all();
        // $data = Obat::with('satuan')->get();
        $data = Obat::latest()->get();
        // return response()->json($data); //fetch data
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addColumn('kategori_id', function($data) {
                return $data->kategoris->kategori;
            })
            ->addColumn('satuan_id', function($data) {
                return $data->satuans->satuan;
            })
            ->addColumn('aksi', function($data)
            {
                $button = '<button class="edit btn btn-warning" id="'.$data->id.'" name="edit">Edit</button>';
                $button .= '<button class="hapus btn btn-danger" id="'.$data->id.'" name="hapus">Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        return view('owner.obatHome', compact('satuan', 'kategori'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $simpan = Obat::create($request->all());
        // if($simpan) {
        //     return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
        // }else{
        //     return response()->json(['text'=>'Data Gagal Disimpan'], 400);
        // }

        //Aturan validasi
        $rules = [
            'nama' => 'required|unique:obats',
            'kode' => 'required|max: 8|unique:obats',
            'dosis' => 'required',
            'indikasi' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
        ]; 

        //teks yang ditampilkan
        $text = [
            'nama.required' => 'Nama Obat Wajib diisi',
            'nama.unique' => 'Nama Obat sudah ada',
            'kode.required' => 'Kode Obat Wajib diisi',
            'kode.max' => 'Kode Obat maximal 8 digit',
            'kode.unique' => 'Kode Obat sudah ada',
            'dosis.required' => 'Dosis Wajib diisi',
            'indikasi.required' => 'Indikasi Wajib diisi',
            'kategori_id.required' => 'Kategori Wajib diisi',
            'satuan_id.required' => 'Satuan Wajib diisi',
        ]; 

        $validasi = Validator::make($request->all(), $rules, $text);

        if($validasi->fails()) {
            return response()->json(['sucess' => 0, 'text' => $validasi->errors()->first()], 422); //422 untuk error validation, dan first() untuk menampilkan error pertama (tidak semua)
        }
        
        $simpan = Obat::create($request->all());
        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Disimpan'], 422);
        }
    }

    public function edits(Request $request)
    {
        // dd($request->all());
        $data = Obat::find($request->id);
        return response()->json($data);
    }

    public function updates(Request $request)
    {
        // dd($request->all());
        $data = Obat::find($request->id);
        $simpan = $data->update($request->all());

        // return response()->json($data);

        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Diperbarui'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Disimpan'], 400);
        }
    }

    public function hapus(Request $request)
    {
        $data = Obat::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Dihapus'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Dihapus'], 400);
        }
    }

}
