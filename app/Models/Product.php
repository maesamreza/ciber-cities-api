<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function color(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }
    
    public function size(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value),
            set: fn ($value) => json_encode($value)
        );
    }

    // public function getColorAttribute($value){
    //     dd($value);
    //     return json_decode($value);
    // }

    // public function setColorAttribute($value){
    //     return json_encode($value);
    // }
    // public function getDetailsAttribute($value){
    //     return json_decode($value);
    // }

    // public function setDetailsAttribute($value){
    //     return json_encode($value);
    // }
    // public function getSizeAttribute($value){
    //     return json_decode($value);
    // }

    // public function setSizeAttribute($value){
    //     return json_encode($value);
    // }
}
