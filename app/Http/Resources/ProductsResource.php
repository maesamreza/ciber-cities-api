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
            'brand'=>$this->brand, 
            'color'=>$this->color,
            'discount'=>$this->discount_price,
            'price'=>$this->price,
            'product_details'=>$this->details,
            'product_image'=>asset('/storage/image/'.$this->image),
            'product_selected_qty'=>$this->selected_qty,
            'product_status'=>$this->status,
            'product_stock'=>$this->stock,
            'product_name'=>$this->name,
            'size'=>$this->size,
            // 'short_description'=>$this->short_description,
            // 'description'=>$this->description,
            // 'rating'=>$this->rating,
            // 'review'=>$this->review,
            // 'tags'=>$this->tags,
            // 'weight'=>$this->weight,
    
    ];
    }
}
