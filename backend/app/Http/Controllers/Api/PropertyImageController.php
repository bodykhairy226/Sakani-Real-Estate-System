<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
class PropertyImageController extends Controller
{
    public function index()
    {
        return response()->json(PropertyImage::all());
    }

    public function store(Request $request)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'image_url' => 'required|string',
        'image_public_id' => 'required|string',
    ]);

    $image = PropertyImage::create([
        'property_id' => $request->property_id,
        'image_url' => $request->image_url,
        'image_public_id' => $request->image_public_id,
    ]);

    return response()->json([
        'message' => 'Image added successfully',
        'data' => $image
    ], 201);
}

    public function show($id)
    {
        return response()->json(PropertyImage::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $image = PropertyImage::findOrFail($id);

        $image->update($request->all());

        return response()->json([
            'message' => 'Image updated successfully',
            'data' => $image
        ]);
    }

    public function destroy($id)
    {
        PropertyImage::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Image deleted successfully'
        ]);
    }
}