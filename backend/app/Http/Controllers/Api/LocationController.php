<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    // عرض كل الأماكن
    public function index()
    {
        $locations = Location::all();

        return response()->json($locations);
    }

    // إضافة مكان جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name',
        ]);

        $location = Location::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Location created successfully',
            'data' => $location,
        ], 201);
    }

    // عرض مكان واحد
    public function show($id)
    {
        $location = Location::findOrFail($id);

        return response()->json($location);
    }

    // تعديل مكان
    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
        ]);

        $location->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Location updated successfully',
            'data' => $location,
        ]);
    }

    // حذف مكان
    public function destroy($id)
    {
        $location = Location::findOrFail($id);

        $location->delete();

        return response()->json([
            'message' => 'Location deleted successfully'
        ]);
    }
}