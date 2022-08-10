<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\Supplier::factory(100)->create();
        // $this->call(LaratrustSeeder::class);
        Kategori::create([
            'kategori' => 'Bebas'
        ]);
        Kategori::create([
            'kategori' => 'Bebas Terbatas'
        ]);
        Kategori::create([
            'kategori' => 'Narkotika'
        ]);

        Satuan::create([
            'satuan' => 'Gram'
        ]);
        Satuan::create([
            'satuan' => 'Pcs'
        ]);
    }
}
