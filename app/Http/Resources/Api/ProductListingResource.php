<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'id'                => $this->id,
            'name'              => $this->name,
            'sku'               => $this->sku ?? 0,
            'stocks'            => $this->stocks,
            'brand_id'          => $this->brand_id,
            'brand_name'        => $this->brand?->name,
            'category_id'       => $this->category_id,
            'sub_category_id'   => $this->sub_category_id,
            'sub_child_id'      => $this->sub_child_id,
            'product_type_id'   => $this->product_type_id,
            'product_type_name' => $this->productType->name ?? null,
            'price'             => $this->price,
            'description'       => $this->description,
            'key_information'   => $this->key_information,
            'is_active'         => $this->is_active,
            'image'             => !empty($this->images[0]) ? $this->images[0]->image : request()->getSchemeAndHttpHost() . '/placeholder.png',
            'fav'               => $this->fav,
            'is_out_of_stock'   => ($this->stocks && $this->stocks > 0) ? false : true,
            'except_title'      => $this->except_title,
        ];

        return $result;
    }
}
