<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert(
            [
                [
                    'uuid' => '4b1c1ae5-8ddf-4417-a8e9-5860f9dda8b7',
                    'name' => 'pabrik A'
                ],
                [
                    'uuid' => '940d6054-8dcd-4df1-9d09-4781f0da14a9',
                    'name' => 'pabrik B'
                ]
            ]
        );
    }
}
