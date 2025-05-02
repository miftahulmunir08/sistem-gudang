<?php

namespace App\Http\Controllers\Data_Mutation;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MutationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['menu_active'] = 'mutation';
        return view('mutation/index', $data);
    }

    public function getData()
    {
        $mutation = Mutation::with(['lokasi_pertama', 'lokasi_kedua', 'product', 'pegawai'])->get();

        return DataTables::of($mutation)
            ->addColumn('no', function () {
                return 'DT_RowIndex';
            })
            ->addColumn('tanggal', function ($mutation) {
                return \Carbon\Carbon::parse($mutation->tanggal)->format('d/m/Y');
            })
            ->addColumn('lokasi_awal', function ($mutation) {
                return $mutation->lokasi_pertama->name;
            })
            ->addColumn('lokasi_akhir', function ($mutation) {
                return $mutation->lokasi_kedua->name;
            })
            ->addColumn('product_name', function ($mutation) {
                return $mutation->product->name;
            })
            ->addColumn('pegawai_name', function ($mutation) {
                return $mutation->pegawai->name;
            })

            ->addColumn('jumlah', function ($mutation) {
                return $mutation->jumlah;
            })

            ->addColumn('jenis', function ($mutation) {
                return $mutation->jenis;
            })

            ->addColumn('keterangan', function ($mutation) {
                return $mutation->keterangan;
            })

            ->addColumn('action', function ($mutation) {
                return '
                <a onclick="byid(`' . $mutation->uuid . '`)" href="#" class="btn btn-sm btn-primary">Edit</a>
                <a onclick="destroy(`' . $mutation->uuid . '`)" href="#" class="btn btn-sm btn-danger">Delete</a>
                ';
            })
            ->rawColumns(['action']) // Jika ada kolom HTML
            ->addIndexColumn()
            ->make(true);
    }


    public function getAll()
    {
        $mutation = Mutation::all();
        return response()->json(['data' => $mutation]);
    }


    // public function getAll()
    // {
    //     $category = Category::all();
    //     return response()->json(['data' => $category]);
    // }

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
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'location_from' => 'required',
            'location_to' => 'required',
            'product' => 'required',
            'qty' => 'required',
            'pegawai' => 'required',
            'jenis_mutasi' => 'required|in:masuk,keluar,pindah'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        } else {
            $id = \Illuminate\Support\Str::uuid()->toString();


            if ($request->isJson()) {
                // dari API
                $data['tanggal'] = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
            } else {
                // dari Blade (form biasa), kemungkinan sudah 'Y-m-d'
                $data['tanggal'] = $request->tanggal;
            }

            $data['uuid']      = $id;
            $data['lokasi_awal']      = $request->location_from;
            $data['lokasi_akhir']      = $request->location_to;
            $data['product_id']      = $request->product;
            $data['jumlah']      = $request->qty;
            $data['pegawai_id']      = $request->pegawai;
            $data['jenis']      = $request->jenis_mutasi;
            $data['keterangan']      = '';


            $mutation = Mutation::create($data);

            if (!$mutation) {
                return response()->json([
                    'message' => '404',
                    'error' => 'Insert Mutation Failed',
                ], 404);
            }

            return response()->json([
                'message' => '200',
                'data' => $mutation,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if ($id != null) {
            $mutation = Mutation::where('uuid', $id)->first();
            if (!$mutation) {
                return response()->json([
                    'message' => '404',
                    'error' => 'Mutation not found',
                ], 404);
            }

            return response()->json([
                'message' => '200',
                'data' => $mutation,
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
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'tanggal' => 'required',
            'location_from' => 'required',
            'location_to' => 'required',
            'product' => 'required',
            'qty' => 'required',
            'pegawai' => 'required',
            'jenis_mutasi' => 'required|in:masuk,keluar,pindah'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        } else {

            $mutation = Mutation::findOrFail($id);

            if ($request->isJson()) {
                // dari API
                $data['tanggal'] = Carbon::createFromFormat('d/m/Y', $request->tanggal)->format('Y-m-d');
            } else {
                // dari Blade (form biasa), kemungkinan sudah 'Y-m-d'
                $data['tanggal'] = $request->tanggal;
            }
            
            $data['lokasi_awal']      = $request->location_from;
            $data['lokasi_akhir']      = $request->location_to;
            $data['product_id']      = $request->product;
            $data['jumlah']      = $request->qty;
            $data['pegawai_id']      = $request->pegawai;
            $data['jenis']      = $request->jenis_mutasi;
            $data['keterangan']      =  '';

            $mutation->update($data);

            if (!$mutation) {
                return response()->json([
                    'message' => '404',
                    'error' => 'Update Mutation Failed',
                ], 404);
            }
            return response()->json([
                'message' => '200',
                'data' => $mutation,
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $mutation = Mutation::findOrFail($id);

        // Delete the mutation
        $mutation->delete();

        return response()->json(['message' => 'Mutation deleted successfully']);
    }
}
