<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesTableSeeder::class);
        User::factory()->count(5)->create();
        $this->call(StatusSeeder::class);
        $this->call(ProductTypeSeeder::class);
        Product::factory()->count(5)->create();
    }
}
