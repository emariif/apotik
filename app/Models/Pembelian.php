<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    protected $fillable = [
        'faktur',
        'item',
        'harga',
        'qty',
        'tanggal',
        'totalKotor',
        'pajak',
        'diskon',
        'totalBersih',
        'keterangan',
        'supplier_id',
        'admin',
    ];

    protected $with = ['suppliers', 'users'];

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'admin', 'id');
    }
}
