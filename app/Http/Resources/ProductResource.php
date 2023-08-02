<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'price' => $this->price,
            'in_stock' => ($this->qty > 0) ? 1 : 0,
            'product_category_id' => ProductCategoryResource::make($this->category)

            //neu belongsTo => make
            //neu hasMany => collection
        ];

        
    }
}
