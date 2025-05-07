<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['menu_active'] = 'category';
        return view('master/category/index', $data);
    }


    public function getData()
    {
        $category = Category::select(['id', 'uuid', 'name']);

        return DataTables::of($category)
            ->addColumn('no', function () {
                return 'DT_RowIndex';
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->addColumn('action', function ($category) {
                return '
                <a onclick="byid(`' . $category->uuid . '`)" href="#" class="btn btn-sm btn-primary">Edit</a>
                <a onclick="destroy(`' . $category->uuid . '`)" href="#" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['action']) // Jika ada kolom HTML
            ->addIndexColumn()
            ->make(true);
    }

    /**
     * @OA\Get(
     *     path="/api/category-action/all",
     *     summary="Ambil daftar kategori",
     *     tags={"Category"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar kategori",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "data": {
     *                     {"name": "string"},
     *                     {"name": "string"}
     *                 }
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Unauthenticated."}
     *         )
     *     )
     * )
     */

    public function getAll()
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Token invalid or missing'
            ], 401);
        }

        $category = Category::all();
        return response()->json(['data' => $category]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *   path="/api/categories",
     *   tags={"Category"},
     *   summary="Category",
     *   description="Category",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="Accept",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="application/json"
     *         )
     *     ),
     *   @OA\RequestBody(
     *     required=true,
     *     description="credentials",
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         @OA\Property(property="category_name", type="string", format="text", example="Vitamin"),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar kategori",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "data": {
     *                     {"name": "string"},
     *                 }
     *             }
     *         )
     *   ),
     *   @OA\Response(response="201", description="Successful operation"),
     *   @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "Unauthenticated."}
     *         )
     *     ),
     *   @OA\Response(response="403", description="Forbidden"),
     * )
     */


    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required'
        ]);

        $id = \Illuminate\Support\Str::uuid()->toString();

        $data['uuid']      = $id;
        $data['name']      = $request->category_name;

        $category = Category::create($data);

        if (!$category) {
            return response()->json([
                'message' => '404',
                'error' => 'Insert Category Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $category,
        ], 200);
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *   path="/api/categories/{id}",
     *   tags={"Category"},
     *   summary="Lihat detail kategori",
     *   description="Mengambil data kategori berdasarkan ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID kategori",
     *     @OA\Schema(type="string", example="6cecf10af2584e8ea7c46fdaab339978")
     *   ),
     *   @OA\Parameter(
     *     name="Accept",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string", default="application/json")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Data kategori ditemukan",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "data": {
     *           "id": 1,
     *           "category_name": "Vitamin"
     *         }
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(
     *     response=404,
     *     description="Kategori tidak ditemukan",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Kategori tidak ditemukan"}
     *     )
     *   )
     * )
     */

    public function show(string $id = null)
    {
        if ($id != null) {
            $category = Category::where('uuid', $id)->first();
            if (!$category) {
                return response()->json([
                    'message' => '404',
                    'error' => 'Category not found',
                ], 404);
            }

            return response()->json([
                'message' => '200',
                'data' => $category,
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *   path="/api/categories/{id}",
     *   tags={"Category"},
     *   summary="Update kategori",
     *   description="Mengubah data kategori berdasarkan ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string", example="6cecf10af2584e8ea7c46fdaab339978")
     *   ),
     *   @OA\Parameter(
     *     name="Accept",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string", default="application/json")
     *   ),
     *   @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *       mediaType="application/x-www-form-urlencoded",
     *       @OA\Schema(
     *         required={"category_name"},
     *         @OA\Property(property="category_name", type="string", example="Obat-obatan")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Kategori berhasil diupdate",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Kategori berhasil diupdate", "data": {"id": 1, "category_name": "Obat-obatan"}}
     *     )
     *   ),
     *   @OA\Response(response=400, description="Bad Request"),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Kategori tidak ditemukan")
     * )
     */
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'category_name' => 'required|regex:/^[a-zA-Z\s-]+$/u',
        ]);

        // Find category or return 404
        $category = Category::findOrFail($id);

        $data['uuid']      = $id;
        $data['name']      = $request->category_name;

        // Update the category
        $category->update($data);

        if (!$category) {
            return response()->json([
                'message' => '404',
                'error' => 'Update Category Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $category,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *   path="/api/categories/{id}",
     *   tags={"Category"},
     *   summary="Hapus kategori",
     *   description="Menghapus kategori berdasarkan ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     @OA\Schema(type="string", example="6cecf10af2584e8ea7c46fdaab339978")
     *   ),
     *   @OA\Parameter(
     *     name="Accept",
     *     in="header",
     *     required=true,
     *     @OA\Schema(type="string", default="application/json")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Kategori berhasil dihapus",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Kategori berhasil dihapus"}
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(response=404, description="Kategori tidak ditemukan")
     * )
     */

    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);

        // Delete the category
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
