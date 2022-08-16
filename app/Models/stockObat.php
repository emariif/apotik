<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stockObat extends Model
{
    use HasFactory;
    protected $table = 'stock_obats';
    protected $with = ['obats', 'users'];
    protected $fillable = [
        'obat_id',
        'masuk',
        'keluar',
        'jual',
        'beli',
        'expired',
        'stock',
        'keterangan',
        'admin',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function obats()
    {
        return $this->belongsTo('App\Models\obat', 'obat_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'admin', 'id');
    }
}
