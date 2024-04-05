<?php

namespace App\Http\Controllers\Api;

use App\Dtos\ApiResponse;
use App\Dtos\LoginResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use OpenApi\Attributes as OAT;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    #[OAT\Post(
        path: "/api/register",
        summary: "Register User",
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: "application/json",
                schema: new OAT\Schema(ref: "#/components/schemas/RegisterDto")
            )),
        tags: ["Auth"],
        responses: [
            new OAT\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_OK, description: "users exists", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error", content: new OAT\JsonContent(type: ApiResponse::class))
        ]
    )]
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = Validator::make($request->all(), [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|min:4'
            ]);

            if ($validated->fails()) {
                return response()->json(
                    ApiResponse::validationError(
                        errors: $validated->errors(),
                        message: 'validation error'
                    ), Response::HTTP_UNAUTHORIZED);
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json(
                ApiResponse::success(
                    data: $user,
                    message: 'User created'
                ), Response::HTTP_CREATED);

        } catch (\Throwable $th) {
            return response()->json(
                ApiResponse::fail(message: $th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OAT\Post(
        path: "/api/login",
        summary: "Authenticte user",
        requestBody: new OAT\RequestBody(
            required: true,
            content: new OAT\MediaType(
                mediaType: "application/json",
                schema: new OAT\Schema(ref: "#/components/schemas/LoginDto")
            )),
        tags: ["Auth"],
        responses: [
            new OAT\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_OK, description: "users exists", content: new OAT\JsonContent(type: ApiResponse::class)),
            new OAT\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error", content: new OAT\JsonContent(type: ApiResponse::class))
        ]
    )]
    public function login(Request $request): Response
    {
        try {
            $validated = Validator::make($request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]);

            if ($validated->fails()) {
                return response()->json(
                    ApiResponse::validationError(
                        errors: $validated->errors(),
                        message: 'validation error'
                    ), Response::HTTP_UNAUTHORIZED);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json(
                    ApiResponse::fail(
                        message: 'Email & Password does not match with our record.',
                    ), Response::HTTP_BAD_REQUEST);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json(
                LoginResponse::success(
                    token: $user->createToken("API TOKEN")->plainTextToken,
                    message: 'User Logged In Successfully'
                ), Response::HTTP_OK);

        } catch (\Throwable $th) {
            return response()->json(
                ApiResponse::fail(message: $th->getMessage()),
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[OAT\Get(
        path: "/api/user",
        summary: "Return authenticated user information",
        security: [
            [
                'bearerAuth' => []
            ]
        ],
        tags: ["Auth"],
        responses: [
            new OAT\Response(response: Response::HTTP_OK, description: "users retrieved success"),
            new OAT\Response(response: Response::HTTP_UNAUTHORIZED, description: "Unauthorized"),
            new OAT\Response(response: Response::HTTP_NOT_FOUND, description: "not found"),
            new OAT\Response(response: Response::HTTP_INTERNAL_SERVER_ERROR, description: "Server Error")
        ]
    )]
    public function getUser(Request $request): Response
    {
        return $request->user();
    }
}
