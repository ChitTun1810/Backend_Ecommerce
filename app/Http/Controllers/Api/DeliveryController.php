<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\Township;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    public function getAllCity()
    {
        $city = City::cursor();

        return response()->json([
            'success' => true,
            'data'    => $city,
        ]);
    }
    
    public function getTownships($id)
    {
        $townships = Township::where('city_id', $id)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $townships,
        ]);
    }

    public function getDeliveryFees($cityId, $townshipId)
    {
        $result = Township::where('city_id', $cityId)
            ->where('id', $townshipId)
            ->first();

        return response()->json([
            'success' => true,
            'data'    => $result->delivery_fee,
        ]);
    }
}
