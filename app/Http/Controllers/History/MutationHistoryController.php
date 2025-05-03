<?php

namespace App\Http\Controllers\History;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MutationHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['menu_active'] = 'history';
        return view('history/index', $data);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function filter(Request $request)
    {
        $mutation = Mutation::with(['lokasi_pertama', 'lokasi_kedua', 'product', 'pegawai']);

        if ($request->filled('product_id')) {
            $mutation->where('product_id', $request->product_id);
        }

        if ($request->filled('pegawai_id')) {
            $mutation->where('pegawai_id', $request->pegawai_id);
        }

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

    public function filter_api(Request $request)
    {
        $mutation = Mutation::with(['lokasi_pertama', 'lokasi_kedua', 'product', 'pegawai']);

        if ($request->filled('product_id')) {
            $mutation->where('product_id', $request->product_id);
        }

        if ($request->filled('pegawai_id')) {
            $mutation->where('pegawai_id', $request->pegawai_id);
        }

        $data = $mutation->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => '404',
                'error' => 'Mutation not found',
            ], 404);
        }

        return response()->json([
            'message' => '200',
            'data' => $data,
        ], 200);
    }
}
