<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::create(['name' => 'Technical Support', 'description' => 'Technical problems']);
        Category::create(['name' => 'Account Issue', 'description' => 'Login and account problems']);
        Category::create(['name' => 'Hardware', 'description' => 'Hardware related issues']);
        Category::create(['name' => 'Software', 'description' => 'Software related issues']);
    }
}