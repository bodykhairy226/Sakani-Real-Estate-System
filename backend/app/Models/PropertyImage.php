<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [

    'property_id',

    'image_url',

    'image_public_id',

];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}