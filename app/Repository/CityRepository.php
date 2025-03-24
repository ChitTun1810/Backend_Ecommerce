<?php

namespace App\Repository;

use App\Models\City;
use Illuminate\Http\Request;

class CityRepository {
    public function listing(Request $request)
    {
        $city = City::orderBy('id', 'desc')
            ->paginate($request->limit ?? 10);

        return $city;
    }

    public function store(Request $request)
    {
        $city = City::create([
            'name'  => $request->name,
        ]);

        return $city;
    }

    public function update(Request $request, City $city)
    {
        $city->update([
            'name'  => $request->name,
        ]);

        return $city;
    }

    public function delete(City $city)
    {
        $city->delete();
    }
}
