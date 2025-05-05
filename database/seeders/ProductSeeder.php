<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert(
            [
                [
                    'id' => 1,
                    'uuid' => '0cf1e872-31ef-4584-9c48-6a5344824706',
                    'category_id' => '6cecf10a-f258-4e8e-a7c4-6fdaab339978',
                    'name' => 'vitamin',
                    'kode_barang' => 'PRD-001',
                    'harga' => 20.000
                ],
                [
                    'id' => 2,
                    'uuid' => 'b4ada1fe-03bb-44d8-93e3-37d422111fec',
                    'category_id' => 'f959bb32-8776-4c0e-8e10-fe307b5d02c7',
                    'name' => 'pencahar',
                    'kode_barang' => 'PRD-002',
                    'harga' => 10.000
                ]
            ]
        );
    }
}
