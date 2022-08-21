<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;
    protected $fillable = ['nota', 'status', 'tanggal', 'qty', 'pajak', 'diskon', 'subTotal', 'item', 'consumer', 'kasir'];
    protected $with = ['obats', 'pasiens', 'users'];

    public function obats()
    {
        return $this->belongsTo(Obat::class, 'item');
    }

    public function pasiens()
    {
        return $this->belongsTo(Pasien::class, 'consumer');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'kasir');
    }
}
