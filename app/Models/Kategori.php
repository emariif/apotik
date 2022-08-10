<?php

namespace App\Models;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori',
    ];

    public function obats()
    {
        return $this->hasMany(Obat::class, 'kategori_id', 'id');
    }
}
