<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['nota', 'status', 'tanggal', 'qty', 'pajak', 'diskon', 'subTotal', 'item', 'consumer', 'kasir'];
    protected $with = ['obats', 'consumers', 'stock_obats', 'kasirs', 'pembayarans'];

    public function obats()
    {
        return $this->belongsTo(Obat::class, 'item');
    }

    public function consumers()
    {
        return $this->belongsTo(Pasien::class, 'consumer');
    }

    public function stock_obats()
    {
        return $this->belongsTo(StockObat::class, 'obat_id', 'obats.id');
    }

    public function kasirs()
    {
        return $this->belongsTo(User::class, 'kasir');
    }

    public function pembayarans()
    {
        return $this->belongsTo(Pembayaran::class, 'nota', 'nota');
    }

    public static function hitung($id){
        $data = Penjualan::where('nota', $id)
            ->selectRaw('SUM(subTotal) as totalHarga')
            ->selectRaw('nota')
            ->groupBy('nota');
        return $data;
    }

    public static function joinCetak()
    {
        return $data = DB::table('penjualans')
            ->join('obats', 'obats.id', '=', 'penjualans.item')
            ->join('pasiens', 'pasiens.id', '=', 'penjualans.consumer')
            ->join('stock_obats', 'stock_obats.obat_id', '=', 'obats.id')
            ->join('users', 'users.id', '=', 'penjualans.kasir')
            ->join('pembayarans', 'pembayarans.nota', '=', 'penjualans.nota')
            ->select(
                'penjualans.*',
                'obats.nama as nama_obat',
                'obats.indikasi',
                'obats.kode',
                'obats.dosis',
                // 'satuans.satuan',
                'pasiens.nama as customer',
                'pasiens.alamat',
                'pasiens.telp',
                'users.name',
                'pembayarans.total',
                'pembayarans.kembali',
                'pembayarans.diskon',
                'pembayarans.dibayar',
                'stock_obats.jual'
            );
    }
}
