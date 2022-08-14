<?php

namespace App\Models;

use App\Models\Satuan;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Obat extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'kode',
        'dosis',
        'indikasi',
        'kategori_id',
        'satuan_id',
    ];

    protected $with = ['kategoris', 'satuans'];

    public function kategoris()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function satuans()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id', 'id');
    }

    public function stockObats()
    {
        return $this->hasOne(StockObat::class, 'obat_id', 'id');
    }
}
