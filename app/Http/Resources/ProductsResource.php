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
        return [
            'id'=>$this->id,
            'name'=>$this->title,
            'short_description'=>$this->short_description,
            'description'=>$this->description,
            'price'=>$this->price,
            'discounted_price'=>$this->discounted_price,
            'image'=>asset('/storage/image/'.$this->image),
            'rating'=>$this->rating,
            'review'=>$this->review,
            'color'=>$this->color,
            'size'=>$this->size,
            'brand'=>$this->brand,
            'tags'=>$this->tags,
            'selected_qty'=>$this->selected_qty,
            'status'=>$this->status,
            'stock'=>$this->stock,
            // 'weight'=>$this->weight,
    
    ];
    }
}
