<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    public function index()
    {
        // $data = Supplier::all();
        $data = Supplier::latest();
        // return response()->json($data); //fetch data
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addColumn('aksi', function($data)
            {
                $button = '<button class="edit btn btn-warning" id="'.$data->id.'" name="edit">Edit</button>';
                $button .= '<button class="hapus btn btn-danger" id="'.$data->id.'" name="hapus">Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->make(true);
        }
        return view('owner.SupplierHome');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        // $simpan = Supplier::create($request->all());
        // if($simpan) {
        //     return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
        // }else{
        //     return response()->json(['text'=>'Data Gagal Disimpan'], 400);
        // }

        //Aturan validasi
        $rules = [
            'nama' => 'required',
            'telp' => 'required|min:12|unique:suppliers',
            'email' => 'required|unique:suppliers',
            'rekening' => 'required|unique:suppliers',
            'alamat' => 'required',
        ]; 

        //teks yang ditampilkan
        $text = [
            'nama.required' => 'Nama Supplier Wajib diisi',
            'telp.required' => 'Nomor Telepon Wajib diisi',
            'telp.min' => 'Nomor Telepon minimal 12 digit',
            'telp.unique' => 'Nomor Telepon sudah ada',
            'email.required' => 'Email Wajib diisi',
            'email.unique' => 'Email sudah ada',
            'rekening.required' => 'Nomor Rekening Wajib diisi',
            'rekening.unique' => 'Nomor Rekening sudah ada',
            'alamat.required' => 'Alamat Wajib diisi',
        ]; 

        $validasi = Validator::make($request->all(), $rules, $text);

        if($validasi->fails()) {
            return response()->json(['sucess' => 0, 'text' => $validasi->errors()->first()], 422); //422 untuk error validation, dan first() untuk menampilkan error pertama (tidak semua)
        }
        
        $simpan = Supplier::create($request->all());
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
        $data = Supplier::find($request->id);
        return response()->json($data);
    }

    public function updates(Request $request)
    {
        // dd($request->all());
        $data = Supplier::find($request->id);
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
        $data = Supplier::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Dihapus'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Dihapus'], 400);
        }
    }

}
