<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Location;
use App\Models\Pegawai;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $data['menu_active'] = 'dashboard';
        return view('dashboard/index', $data);
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

    public function getDashboardData()
    {
        $product_count = Product::all()->count();
        $category_count = Category::all()->count();
        $pegawai_count = Pegawai::all()->count();
        $lokasi_count = Location::all()->count();

        $data = [
            "product" => $product_count,
            "category" => $category_count,
            "pegawai" => $pegawai_count,
            "location" => $lokasi_count
        ];

        return response()->json(['data' => $data]);
    }
}
