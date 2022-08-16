<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\stockObat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StockObatController extends Controller
{
    public function index()
    {
        // $data = stockObat::all();
        $obat = Obat::where('ready', 'N')->get();
        $user = User::all();
        // $data = stockObat::with('satuan')->get();
        $data = stockObat::latest()->get();
        // return response()->json($data); //fetch data
        if(request()->ajax()) {
            return datatables()->of($data)
            ->addColumn('admin', function($data) {
                // return $data->users['name'];
                return $data->users->name;
                // return isset($data->users['name']) ? $data->users['name'] : '';
            })
            ->addColumn('obat_id', function($data) {
                return $data->obats->nama;
                // return $data->obats['nama'];
                // return isset($data->obats['nama']) ? $data->obats['nama'] : '';
            })
            ->addColumn('aksi', function($data)
            {
                $button = '<button class="edit btn btn-warning" id="'.$data->id.'" name="edit">Edit</button>';
                $button .= '<button class="hapus btn btn-danger" id="'.$data->id.'" name="hapus">Hapus</button>';
                return $button;
            })
            ->rawColumns(['aksi'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('owner.stockObatHome', compact('obat'));
    }

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     // $simpan = stockObat::create($request->all());
    //     // if($simpan) {
    //     //     return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
    //     // }else{
    //     //     return response()->json(['text'=>'Data Gagal Disimpan'], 400);
    //     // }

    //     //Aturan validasi
    //     $rules = [
    //         'nama' => 'required|unique:obats',
    //         'kode' => 'required|max: 8|unique:obats',
    //         'dosis' => 'required',
    //         'indikasi' => 'required',
    //         'kategori_id' => 'required',
    //         'satuan_id' => 'required',
    //     ]; 

    //     //teks yang ditampilkan
    //     $text = [
    //         'nama.required' => 'Nama Obat Wajib diisi',
    //         'nama.unique' => 'Nama Obat sudah ada',
    //         'kode.required' => 'Kode Obat Wajib diisi',
    //         'kode.max' => 'Kode Obat maximal 8 digit',
    //         'kode.unique' => 'Kode Obat sudah ada',
    //         'dosis.required' => 'Dosis Wajib diisi',
    //         'indikasi.required' => 'Indikasi Wajib diisi',
    //         'kategori_id.required' => 'Kategori Wajib diisi',
    //         'satuan_id.required' => 'Satuan Wajib diisi',
    //     ]; 

    //     $validasi = Validator::make($request->all(), $rules, $text);

    //     if($validasi->fails()) {
    //         return response()->json(['sucess' => 0, 'text' => $validasi->errors()->first()], 422); //422 untuk error validation, dan first() untuk menampilkan error pertama (tidak semua)
    //     }
        
    //     $simpan = stockObat::create($request->all());
    //     if($simpan) {
    //         return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
    //         // return view('owner.SupplierHome');
    //     }else{
    //         return response()->json(['text'=>'Data Gagal Disimpan'], 422);
    //     }
    // }

    public function store(Request $request){
        // dd($request->all());
        $data = new stockObat();
        $data->obat_id = $request->obat_id;
        $data->masuk = $request->masuk;
        $data->keluar = $request->keluar;
        $data->jual = $request->jual;
        $data->beli = $request->beli;
        $data->expired = $request->expired;
        $data->stock = $request->stock;
        $data->keterangan = $request->keterangan;
        $data->admin = Auth::user()->id;
        $simpan = $data->save();

        // $simpan = Obat::create($request->all())->where('admin', Auth::user()->id);
        if($simpan) {
            // Page::where('id', $id)->update(array('image' => 'asdasd'));
            // stockObat::table('obats')->where('id', $request->id)->update(['ready' => 'Y']);
            // Obat::with('obats')->where('id', $request->id)->update(['ready' => 'Y']);
            $obat = Obat::find($request->obat_id);
            if($obat) {
                $obat->ready = 'Y';
                $obat->save();
                // return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
            }
            return response()->json(['text'=>'Data Berhasil Disimpan'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Disimpan'], 422);
        }
    }

    public function getObat(Request $request){
        $data = stockObat::where('obat_id', $request->id)->first();
        $null = [
            'stock' => 0
        ];
        
        if($data != null){
            return response()->json(['data' => $data]);
        }else{
            return response()->json(['data' => $null]);
        }
        // return response()->json(['data' => $data]);
    }

    public function edits(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        // $data = stockObat::find($id);
        // $data = stockObat::with('obats')->where('id', $id)->first();
        // $obat = $request->obat_id;
        $data = stockObat::where('id', $id)->first();
        return response()->json($data);
    }

    public function updates(Request $request)
    {
        // dd($request->all());
        $datas = [
            'obat_id' => $request->obat_id,
            'masuk' => $request->masuk,
            'keluar' => $request->keluar,
            'jual' => $request->jual,
            'beli' => $request->beli,
            'expired' => $request->expired,
            'stock' => $request->stock,
            'keterangan' => $request->keterangan,
            'admin' => Auth::user()->id,
        ];
        $data = stockObat::find($request->id);
        // $simpan = $data->update($request->all());
        $simpan = $data->update($datas);

        // return response()->json($data);

        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Diperbarui'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Diperbarui'], 400);
        }
    }

    public function hapus(Request $request)
    {
        $data = stockObat::find($request->id);
        $simpan = $data->delete($request->all());
        if($simpan) {
            return response()->json(['text'=>'Data Berhasil Dihapus'], 200);
            // return view('owner.SupplierHome');
        }else{
            return response()->json(['text'=>'Data Gagal Dihapus'], 400);
        }
    }
}
