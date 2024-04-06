<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = collect(File::files(public_path('products')));
        $products = File::json(public_path('products.json'));

        foreach ($products as $product){
            $code = Str::uuid()->toString();
            $product = Product::create([
                'category_id' => $product['category_id'],
                'uuid' => $code,
                'name' => $product['name'],
                'slug' => Str::random(8)."-".Str::slug($product['name']),
                'price' => $product['original_price'],
                'description' => $product['short_description'],
                'is_new' => (bool)rand(0, 1),
                'is_online' => true,
                'large_description' => $product['description'],
            ]);

            createProductImage($product->id, $code, $images->random()->getPathName());
        }
    }
}
