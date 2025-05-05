<?php

namespace Database\Seeders;

use App\Models\Mutation;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MutasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mutation::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'product_id' => 1,
                    'pegawai_id' => 1,
                    'jenis' => 'masuk',
                    'jumlah' => 2,
                    'lokasi_awal' => 1,
                    'lokasi_akhir' => 2
                ],
                [
                    'uuid' => Str::uuid(),
                    'product_id' => 2,
                    'pegawai_id' => 1,
                    'jenis' => 'masuk',
                    'jumlah' => 250,
                    'lokasi_awal' => 1,
                    'lokasi_akhir' => 2
                ],
            ]
        );
    }
}
