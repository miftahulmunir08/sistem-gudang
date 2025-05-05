<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::insert(
            [
                [
                    'uuid' => Str::uuid(),
                    'name' => 'hartono',
                    'email' => 'hartono@gmail.com',
                    'phone' => '089',
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'kuncoro',
                    'email' => 'kuncoro@gmail.com',
                    'phone' => '085',
                ]
            ]
        );
    }
}
