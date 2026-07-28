<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        return response()->json(
            Property::with('category', 'propertyType', 'location', 'images', 'amenities')
                ->latest()
                ->get()
        );
    }

    public function byCategory($category)
    {
        $properties = Property::with('category', 'propertyType', 'location', 'images', 'amenities')
            ->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            })
            ->latest()
            ->get();

        return response()->json($properties);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'property_type_id' => 'required|exists:property_types,id',
            'category_id' => 'required|exists:categories,id',
            'location_id' => 'required|exists:locations,id',
            'area' => 'required|integer',
            'rooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'floor' => 'nullable|integer',
            'balconies' => 'nullable|integer',
            'finishing' => 'nullable|in:super_lux,lux,semi_finished,red_brick',
            'video_url' => 'nullable|string',
            'video_public_id' => 'nullable|string',
            'status' => 'nullable|in:available,reserved,sold,rented',
            'featured' => 'boolean',
        ]);

        $property = Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'property_type_id' => $request->property_type_id,
            'category_id' => $request->category_id,
            'location_id' => $request->location_id,
            'area' => $request->area,
            'rooms' => $request->rooms,
            'bathrooms' => $request->bathrooms,
            'floor' => $request->floor,
            'balconies' => $request->balconies,
            'finishing' => $request->finishing,
            'video_url' => $request->video_url,
            'video_public_id' => $request->video_public_id,
            'status' => $request->status ?? 'available',
            'featured' => $request->featured ?? false,
        ]);
    
        if ($request->filled('amenities')) {
    $property->amenities()->sync($request->amenities);
}
        return response()->json([
            'message' => 'Property created successfully',
            'data' => Property::with('category', 'propertyType', 'location', 'images', 'amenities')->find($property->id)
        ], 201);
    }

    public function show($id)
    {
        $property = Property::with('category', 'propertyType', 'location', 'images', 'amenities')->findOrFail($id);
        return response()->json($property);
    }

    public function update(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $request->validate([
            'status' => 'nullable|in:available,reserved,sold,rented',
        ]);

        $property->update($request->all());

        return response()->json([
            'message' => 'Property updated successfully',
            'data' => Property::with('category', 'propertyType', 'location', 'images', 'amenities')->find($property->id)
        ]);
    }

    public function destroy($id)
    {
        Property::findOrFail($id)->delete();
        return response()->json(['message' => 'Property deleted successfully']);
    }
}