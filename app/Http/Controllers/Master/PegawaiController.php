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
