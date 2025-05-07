<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Location;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['menu_active'] = 'location';
        return view('master/location/index', $data);
    }

    public function getData()
    {
        $location = Location::select(['id', 'uuid', 'name']);

        return DataTables::of($location)
            ->addColumn('no', function () {
                return 'DT_RowIndex';
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->addColumn('action', function ($location) {
                return '
                <a onclick="byid(`' . $location->uuid . '`)" href="#" class="btn btn-sm btn-primary">Edit</a>
                <a onclick="destroy(`' . $location->uuid . '`)" href="#" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['action']) // Jika ada kolom HTML
            ->addIndexColumn()
            ->make(true);
    }


    /**
     * @OA\Get(
     *     path="/api/location-action/all",
     *     summary="Ambil daftar lokasi",
     *     tags={"Location"},
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
     *         description="Berhasil mendapatkan daftar lokasi",
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
        $location = Location::all();
        return response()->json(['data' => $location]);
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
     *   path="/api/locations",
     *   tags={"Location"},
     *   summary="Location",
     *   description="Location",
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
     *         @OA\Property(property="location_name", type="string", format="text", example="Pabrik C"),
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *         response=200,
     *         description="Berhasil mendapatkan daftar lokasi",
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
            'location_name' => 'required'
        ]);

        $id = \Illuminate\Support\Str::uuid()->toString();

        $data['uuid']      = $id;
        $data['name']      = $request->location_name;

        $location = Location::create($data);

        if (!$location) {
            return response()->json([
                'message' => '404',
                'error' => 'Insert Category Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $location,
        ], 200);
    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *   path="/api/locations/{id}",
     *   tags={"Location"},
     *   summary="Lihat detail lokasi",
     *   description="Mengambil data lokasi berdasarkan ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID lokasi",
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
     *     description="Data lokasi ditemukan",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "data": {
     *           "id": 1,
     *           "location_name": "pabrik C"
     *         }
     *       }
     *     )
     *   ),
     *   @OA\Response(response=401, description="Unauthorized"),
     *   @OA\Response(response=403, description="Forbidden"),
     *   @OA\Response(
     *     response=404,
     *     description="Lokasi tidak ditemukan",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Lokasi tidak ditemukan"}
     *     )
     *   )
     * )
     */


    public function show(string $id)
    {
        if ($id != null) {

            $location = Location::where('uuid', $id)->first();

            if (!$location) {
                return response()->json([
                    'message' => '404',
                    'error' => 'Location not found',
                ], 404);
            }

            return response()->json([
                'message' => '200',
                'data' => $location,
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
     *   path="/api/locations/{id}",
     *   tags={"Location"},
     *   summary="Update Lokasi",
     *   description="Mengubah data lokasi berdasarkan ID",
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
     *         required={"location_name"},
     *         @OA\Property(property="location_name", type="string", example="Pabrik C")
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Lokasi berhasil diupdate",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Lokasi berhasil diupdate", "data": {"id": 1, "location_name": "Pabrik C"}}
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
            'location_name' => 'required|regex:/^[a-zA-Z\s-]+$/u',
        ]);

        // Find category or return 404
        $location = Location::findOrFail($id);

        $data['uuid']      = $id;
        $data['name']      = $request->location_name;

        // Update the category
        $location->update($data);

        if (!$location) {
            return response()->json([
                'message' => '404',
                'error' => 'Update Location Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $location,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */


    /**
     * @OA\Delete(
     *   path="/api/locations/{id}",
     *   tags={"Location"},
     *   summary="Hapus lokasi",
     *   description="Menghapus lokasi berdasarkan ID",
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
     *     description="Lokasi berhasil dihapus",
     *     @OA\JsonContent(
     *       type="object",
     *       example={"message": "Lokasi berhasil dihapus"}
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
        $location = Location::findOrFail($id);

        // Delete the category
        $location->delete();

        return response()->json(['message' => 'Location deleted successfully']);
    }
}
