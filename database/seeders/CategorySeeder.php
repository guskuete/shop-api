<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = File::json(public_path('categories.json'));

        foreach ($categories as $category){
            Category::updateOrCreate([
                'id' => $category['id'],
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
            ]);
        }
    }
}
