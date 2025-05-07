<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Sistem Gudang API",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk aplikasi sistem gudang berbasis Laravel.",
 *     @OA\Contact(email="munirrmiftahul94@gmail.com")
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token Anda. Format: Bearer {token}"
 * )
 *
 * @OA\Server(
 *     url="https://sistemgudang.myporto.icu",
 *     description="Production Server"
 * )
 */
class PingController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/ping",
     *     summary="Cek koneksi API",
     *     tags={"General"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil", 
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="pong")
     *         ) 
     *     )
     * )
     */
    public function ping(): JsonResponse
    {
        return response()->json(['message' => 'pong']);
    }
}
