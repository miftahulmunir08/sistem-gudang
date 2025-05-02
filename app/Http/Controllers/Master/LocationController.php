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
    public function destroy(string $id)
    {
        //
        $location = Location::findOrFail($id);

        // Delete the category
        $location->delete();

        return response()->json(['message' => 'Location deleted successfully']);
    }
}
