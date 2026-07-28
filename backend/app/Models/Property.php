<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Location;
use App\Models\PropertyImage;
use App\Models\Amenity;
use App\Models\PropertyType;

class Property extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'property_type_id',
        'location_id',
        'rent_duration',
        'area',
        'rooms',
        'bathrooms',
        'floor',
        'balconies',
        'finishing',
        'furnishing',
        'video_url',
        'video_public_id',
        'status',
        'featured',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'property_amenities');
    }
}