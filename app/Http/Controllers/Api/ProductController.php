<?php

namespace App\Http\Controllers\Api;

use App\Dtos\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OAT;

class ProductController extends Controller
{
    #[OAT\Get(
        path: "/api/products",
        summary: "Fetch products",
        tags: ["Product"],
        parameters: [
            new OAT\Parameter(
                name: 'limit',
                description: 'Number of products to return',
                in: 'query',
                required: false,
                schema: new OAT\Schema(type: 'integer')
            ),
            new OAT\Parameter(
                name: 'skip',
                description: 'Number of products to skip',
                in: 'query',
                required: false,
                schema: new OAT\Schema(type: 'integer')
            )
        ],
        responses: [
            new OAT\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_OK, description: "Products found",
                content: new OAT\MediaType(
                    mediaType: 'application/json',
                    schema: new OAT\Schema(
                        ref: '#/components/schemas/ProductReadDto'
                    )
                )),
        ]
    )]
    public function index(Request $request)
    {
        try {
            $products = Product::take($request->get('limit') ?? 10)
                ->skip($request->get('skip'))->get();

            return response()->json(
                ApiResponse::success(
                    data: $products,
                    message: 'List of products'
                ), Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json(
                ApiResponse::fail(message: $th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OAT\Get(
        path: "/api/products/{id}",
        summary: "Fetch a single product",
        tags: ["Product"],
        parameters: [
            new OAT\Parameter(
                name: 'id',
                description: 'The ID of the product to fetch',
                in: 'path',
                required: true,
                schema: new OAT\Schema(type: 'integer')
            )
        ],
        responses: [
            new OAT\Response(
                response: Response::HTTP_OK,
                description: "Product found",
                content: new OAT\MediaType(
                    mediaType: 'application/json',
                    schema: new OAT\Schema(ref: '#/components/schemas/ProductReadDto')
                )
            ),
            new OAT\Response(
                response: Response::HTTP_NOT_FOUND,
                description: "Product not found",
                content: new OAT\JsonContent(type: ApiResponse::class)
            ),
            new OAT\Response(
                response: Response::HTTP_INTERNAL_SERVER_ERROR,
                description: "Server Error",
                content: new OAT\JsonContent(type: ApiResponse::class)
            )
        ]
    )]
    public function show(int $id)
    {
        try {
            $product = Product::find($id)->first();

            return response()->json(
                ApiResponse::success(
                    data: $product,
                    message: 'Product details'
                ), Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json(
                ApiResponse::fail(message: $th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
