<?php

namespace App\Http\Controllers\Data_Mutation;

use App\Http\Controllers\Controller;
use App\Models\Mutation;
use Illuminate\Http\Request;
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
        $mutation = Mutation::with(['lokasi_pertama','lokasi_kedua', 'product', 'pegawai'])->get();

        return DataTables::of($mutation)
            ->addColumn('no', function () {
                return 'DT_RowIndex';
            })
            ->addColumn('created_at', function ($mutation) {
                return $mutation->created_at;
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
}
