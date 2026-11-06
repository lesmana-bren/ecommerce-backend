<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray( $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'price'       => (float) $this->price,
            'stock'       => (int) $this->stock,
            'img_url'     => $this->image ? url('storage/' . $this->image) : null,
            'category'    => [
                'id'   => $this->category_id,
                'name' => $this->category?->name, 
            ],
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}