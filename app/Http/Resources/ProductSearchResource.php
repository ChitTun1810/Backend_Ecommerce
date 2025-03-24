<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'id'              => $this->id,
            'name'            => $this->name,
            'price'           => $this->price,
            'image'           => !empty($this->images[0]) ? $this->images[0]->image : request()->getSchemeAndHttpHost() . '/placeholder.png',
        ];

        return $result;
    }
}
