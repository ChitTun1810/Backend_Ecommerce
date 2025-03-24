<?php

namespace App\Repository;

use App\Models\Township;
use Illuminate\Http\Request;

class TownshipRepository
{
    public function listing(Request $request)
    {
        $township = Township::with('city')
            ->orderBy('id', 'desc')
            ->paginate($request->limit ?? 10);

        return $township;
    }

    public function store(Request $request)
    {
        $township = Township::create([
            'name'         => $request->name,
            'city_id'      => $request->city_id,
            'delivery_fee' => $request->delivery_fee,
        ]);

        return $township;
    }

    public function update(Request $request, Township $township)
    {
        $township->update([
            'name'         => $request->name,
            'city_id'      => $request->city_id,
            'delivery_fee' => $request->delivery_fee,
        ]);

        return $township;
    }

    public function delete(Township $township)
    {
        $township->delete();
    }
}
