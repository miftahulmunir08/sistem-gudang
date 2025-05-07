<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Sistem Gudang API",
 *     version="1.0.0",
 *     description="Dokumentasi API untuk aplikasi sistem gudang berbasis Laravel.",
 *     @OA\Contact(
 *         email="munirrmiftahul94@gmail.com"
 *     )
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Masukkan token Anda. Format: Bearer {token}"
 * )
 * @OA\OpenApi(
 *     @OA\Server(
 *         url="https://sistemgudang.myporto.icu/",
 *         description="Production Development"
 *     ),
 *     @OA\Server(
 *         url="http://sistem-gudang.test",
 *         description="Local Server"
 *     )
 * )
 */

abstract class Controller
{
    //
}
