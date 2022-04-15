<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['name'=>$this->title,
        'short_description'=>$this->short_description,
        'description'=>$this->description,
        'price'=>$this->price,
        'discounted_price'=>$this->discounted_price,
        'images'=>$this->images,
        'rating'=>$this->rating,
        'review'=>$this->review,
    
    ];
    }
}
