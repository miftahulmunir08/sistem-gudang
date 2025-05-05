<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert(
            [
                [
                    'uuid' => '6cecf10a-f258-4e8e-a7c4-6fdaab339978',
                    'name' => 'vitamin'
                ],
                [
                    'uuid' => 'f959bb32-8776-4c0e-8e10-fe307b5d02c7',
                    'name' => 'pencahar'
                ]
            ]
        );
    }
}
