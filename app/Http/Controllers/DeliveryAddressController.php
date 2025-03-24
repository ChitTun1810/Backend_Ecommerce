<?php

namespace App\Http\Controllers;

use App\Models\Township;
use Illuminate\Http\Request;

class DeliveryAddressController extends Controller
{
    public function address($cityId, $townshipId)
    {
        $result = Township::where('city_id', $cityId)
            ->where('id', $townshipId)
            ->first();

        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'City or township not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'data'    => $result?->delivery_fee ?? 0,
        ]);
    }
}
