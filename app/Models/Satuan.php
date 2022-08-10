<?php

namespace App\Models;

use App\Models\Obat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'satuan',
    ];

    public function obats()
    {
        return $this->hasMany(Obat::class);
    }
}
