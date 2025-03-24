<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Repository\BrandRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(public BrandRepository $brandRepository)
    {
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('brand_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $brands = $this->brandRepository->listing($request);
        return Inertia::render("Admin/Brand/Index", [
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('brand_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return Inertia::render("Admin/Brand/Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $this->brandRepository->store($request);

        return to_route('admin.brands.index');

    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        abort_if(Gate::denies('brand_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $brand = Brand::findOrFail($id);
        return Inertia::render("Admin/Category/Create", [
            "brand" => $brand,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        abort_if(Gate::denies('brand_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $brand = Brand::findOrFail($id);

        return Inertia::render('Admin/Brand/Edit', [
            'brand' => $brand,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $brand = Brand::findOrFail($id);

        $this->brandRepository->update($request, $brand);

        return to_route('admin.brands.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $this->brandRepository->delete($brand);
        // return to_route('admin.brands.index');
    }
}
