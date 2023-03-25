<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
                'name' => 'item',
                'description' => 'items',
                'status_id' => 1
            ],
            [
                'name' => 'service',
                'description' => 'services',
                'status_id' => 1
            ]
        ];
        foreach ($status as $status) {
            ProductType::updateOrCreate($status);
        }
    }
}
