<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['nota', 'status', 'tanggal', 'qty', 'pajak', 'diskon', 'subTotal', 'item', 'consumer', 'kasir'];
    protected $with = ['obats', 'pasiens', 'stock_obats', 'users'];

    public function obats()
    {
        return $this->belongsTo(Obat::class, 'item');
    }

    public function pasiens()
    {
        return $this->belongsTo(Pasien::class, 'consumer');
    }

    public function stock_obats()
    {
        return $this->belongsTo(StockObat::class, 'obat_id', 'obats.id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'kasir');
    }

    public static function hitung($id){
        $data = Penjualan::where('nota', $id)
            ->selectRaw('SUM(subTotal) as totalHarga')
            ->selectRaw('nota')
            ->groupBy('nota');
        return $data;
    }
}
