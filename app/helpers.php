<?php

use App\Models\ProductImage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Interfaces\ImageInterface;
use JetBrains\PhpStorm\NoReturn;

function checkAndCreateDirectoryIfNotExists($path)
{
    if (!File::isDirectory($path)) {
        File::makeDirectory($path);
    }
}


function createProductImage($product_id, $code, $image_path)
{
    $manager = new ImageManager(new Driver());

    $product_image_path = public_path("storage/images/products/{$code}");

    checkAndCreateDirectoryIfNotExists(public_path('storage/images'));
    checkAndCreateDirectoryIfNotExists(public_path('storage/images/products'));
    checkAndCreateDirectoryIfNotExists($product_image_path);

//    $image_path = "{$product_image_path}/$image";

    $variants = [
        'large' => 1024,
        'medium' => 820,
        'small' => 520,
        'thumb' => 300,
    ];

    if (File::exists($image_path)) {
        $image = $manager->read($image_path);

        createImageVariants($image, $variants, $product_image_path, $image_path, $product_id);

    } else {
        throw new FileNotFoundException("The file {$image_path} does not exist.");
    }
}

#[NoReturn]
function createImageVariants( $image, $variants, $path, $image_path, $product_id): void
{
    $variantsImages = [];

    foreach ($variants as $key => $width){
        $image->scale(width: $width);
        $image_name = "{$key}.webp";
        $image->toWebp(100);
        $image->save("{$path}/$image_name");
        $variantsImages[$key] = $image_name;
    }

    ProductImage::create([
        'product_id' => $product_id,
        'name' => $variantsImages['large'],
        'thumb' => $variantsImages['thumb'],
        'small' => $variantsImages['small'],
        'medium' => $variantsImages['medium'],
    ]);

//    deleteImage($image_path);
}

function deleteImage($path): void
{
    if(File::exists($path)){
        File::delete($path);
    }
}
