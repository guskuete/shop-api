<?php

use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
//    $products =  Product::get();
//    createProductImage(1, '12345', "/Users/guskuete/Projects/portfolio/shopAPI/public/camera.jpg");

    return redirect('/api/documentation');
});

