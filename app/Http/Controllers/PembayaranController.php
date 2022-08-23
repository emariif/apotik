<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function store(Request $request)
    {
        // dd($request->all());
        $simpan = Pembayaran::create($request->all());
        if ($simpan) {
            return response()->json(['text' => 'Pembayaran Berhasil'], 200);
        } else {
            return response()->json(['text' => 'Pembayaran Gagal'], 422);
        }
    }
}
