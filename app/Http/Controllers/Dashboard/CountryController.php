<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::paginate(10);
        return Inertia::render("Admin/Country/Index", [
            'countries' => $countries,
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Country/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        Country::create([
            'name' => $request->name,
        ]);

        return to_route('admin.countries.index');
    }

    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return Inertia::render('Admin/Country/Edit', [
            'country' => $country,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $country = Country::findOrFail($id);

        $country->update([
            'name' => $request->name,
        ]);

        return to_route('admin.countries.index');
    }

    public function destroy($id)
    {
        $country = Country::find($id);
        $country->delete();
        return to_route('admin.countries.index');
    }

}
