<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\City;
use Inertia\Inertia;
use App\Models\Township;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Repository\TownshipRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class TownshipController extends Controller
{
    public function __construct(public TownshipRepository $townshipRepository)
    {
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('township_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $townships = $this->townshipRepository->listing($request);
        $setting   = Setting::active()->first();
        return Inertia::render("Admin/Township/Index", [
            "townships" => $townships,
            'setting'   => $setting,
        ]);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('township_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $cities = City::all();
        return Inertia::render("Admin/Township/Create", [
            'cities' => $cities,
        ]);
    }

    public function show($id)
    {
        abort_if(Gate::denies('township_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $township = Township::find($id);

        return Inertia::render("Admin/Township/Show", [
            'township' => $township,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'city_id'      => 'required|integer|exists:cities,id',
            'delivery_fee' => 'required',
        ]);

        $this->townshipRepository->store($request);

        return to_route('admin.townships.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('township_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $cities   = City::all();
        $township = Township::findOrFail($id);

        return Inertia::render('Admin/Township/Edit', [
            'cities'   => $cities,
            'township' => $township,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'city_id'      => 'required|integer|exists:cities,id',
            'delivery_fee' => 'required',
        ]);

        $township = Township::findOrFail($id);

        $this->townshipRepository->update($request, $township);

        return to_route('admin.townships.index');
    }

    public function destroy($id)
    {
        $township = Township::findOrFail($id);
        $this->townshipRepository->delete($township);
    }
}
