<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutListingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array
    {
        $result = [
            'cart_id'     => $this->id,
            'customer_id' => $this->customer_id,
            'quantity'    => $this->quantity,
            'product_id'  => $this->product->id,
            'name'        => $this->product->name,
            'sku'         => $this->product->sku,
            'stocks'      => $this->product->stocks,
            'price'       => $this->product->price,
            'image'       => !empty($this->product->images[0]) ? $this->product->images[0]->image : request()->getSchemeAndHttpHost() . '/placeholder.png',
        ];

        return $result;
    }
}
