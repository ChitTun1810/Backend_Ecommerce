<?php

namespace App\Http\Controllers;

use App\Models\City;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Repository\CityRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class CityController extends Controller
{
    public function __construct(public CityRepository $cityRepository)
    {
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('city_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities = $this->cityRepository->listing($request);

        return Inertia::render("Admin/City/Index", [
            "cities" => $cities,
        ]);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('city_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render("Admin/City/Create");
    }

    public function show($id)
    {
        abort_if(Gate::denies('city_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city = City::find($id);

        return Inertia::render("Admin/City/Show", [
            'city' => $city,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $this->cityRepository->store($request);

        return to_route('admin.cities.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('city_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $city = City::findOrFail($id);

        return Inertia::render('Admin/City/Edit', [
            'city' => $city,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $city = City::findOrFail($id);

        $this->cityRepository->update($request, $city);

        return to_route('admin.cities.index');
    }

    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $this->cityRepository->delete($city);
    }
}
