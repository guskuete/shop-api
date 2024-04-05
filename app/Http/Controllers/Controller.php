<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;


#[
    OA\Info(version: "1.0.0", description: "Shop API", title: "Shop API Documentation"),
    OA\Server(url: 'http://localhost:8000', description: "Local Server"),
    OA\Server(url: 'https://shopapi.gustaveckt.com', description: "Production Server"),
    OA\SecurityScheme( securityScheme: 'bearerAuth', type: "http", name: "Authorization", in: "header", scheme: "bearer"),
]
abstract class Controller
{
    //
}
