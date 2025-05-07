<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['menu_active'] = 'user';
        return view('master/user/index', $data);
    }

    public function getData()
    {
        $pegawai = Pegawai::select(['id', 'uuid', 'name', 'email', 'phone']);

        return DataTables::of($pegawai)
            ->addColumn('no', function () {
                return 'DT_RowIndex';
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->filterColumn('email', function ($query, $keyword) {
                $query->where('email', 'like', "%{$keyword}%");
            })
            ->filterColumn('phone', function ($query, $keyword) {
                $query->where('phone', 'like', "%{$keyword}%");
            })
            ->addColumn('action', function ($pegawai) {
                return '
                <a onclick="byid(`' . $pegawai->uuid . '`)" href="#" class="btn btn-sm btn-primary">Edit</a>
                <a onclick="destroy(`' . $pegawai->uuid . '`)" href="#" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['action']) // Jika ada kolom HTML
            ->addIndexColumn()
            ->make(true);
    }


    /**
     * @OA\Get(
     *     path="/api/pegawai-action/all",
     *     summary="Ambil daftar pegawai",
     *     tags={"Employee"},
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
     *         description="Berhasil mendapatkan daftar employee",
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
        $pegawai = Pegawai::all();
        return response()->json(['data' => $pegawai]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * @OA\Post(
     *   path="/api/pegawai",
     *   tags={"Employee"},
     *   summary="Employee",
     *   description="Employee",
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
     *       @OA\Property(property="pegawai_name", type="string", format="text", example="Hartono"),
     *       @OA\Property(property="pegawai_email", type="email", format="email", example="hartono@gmail.com"),
     *       @OA\Property(property="pegawai_phone", type="string", format="text", example="085"),
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
     *                     {"name": "string","email":"string","phone":"string"},
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
            'pegawai_name' => 'required|alpha:ascii',
            'pegawai_email' => 'required|email',
            'pegawai_phone' => 'required|numeric',
        ]);

        $id = \Illuminate\Support\Str::uuid()->toString();

        $data['uuid']      = $id;
        $data['name']      = $request->pegawai_name;
        $data['email']      = $request->pegawai_email;
        $data['phone']      = $request->pegawai_phone;


        $pegawai = Pegawai::create($data);

        if (!$pegawai) {
            return response()->json([
                'message' => '404',
                'error' => 'Insert Customer Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $pegawai,
        ], 200);
    }

    /**
     * Display the specified resource.
     */


    /**
     * @OA\Get(
     *   path="/api/pegawai/{id}",
     *   tags={"Location"},
     *   summary="Lihat detail pegawai",
     *   description="Mengambil data pegawai berdasarkan ID",
     *   security={{"bearerAuth":{}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID pegawai",
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
     *     description="Data pegawai ditemukan",
     *     @OA\JsonContent(
     *       type="object",
     *       example={
     *         "data": {
     *           "id": 1,
     *           "pegawai_name": "string"
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
        $pegawai = Pegawai::where(['uuid' => $id])->first();
        if (!$pegawai) {
            return response()->json([
                'message' => '404',
                'error' => 'Pegawai not found',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $pegawai,
        ], 200);
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


    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'pegawai_name' => 'required|alpha:ascii',
            'pegawai_email' => 'required|email',
            'pegawai_phone' => 'required|numeric',
        ]);

        // Find category or return 404
        $pegawai = Pegawai::findOrFail($id);

        $data['uuid']      = $id;
        $data['name']      = $request->pegawai_name;
        $data['email']      = $request->pegawai_email;
        $data['phone']      = $request->pegawai_phone;


        // Update the category
        $pegawai->update($data);

        if (!$pegawai) {
            return response()->json([
                'message' => '404',
                'error' => 'Update Customer Failed',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $pegawai,
        ], 200);

        // Return the updated category
        // return $pegawai;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->delete();
        return response()->json(['message' => 'Pegawai deleted successfully']);
    }
}
