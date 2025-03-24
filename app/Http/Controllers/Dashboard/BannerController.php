<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repository\BannerRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

class BannerController extends Controller
{
    public function __construct(public BannerRepository $bannerRepository)
    {
    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('banner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banners = $this->bannerRepository->listing($request);

        return Inertia::render("Admin/Banner/Index", [
            "banners" => $banners,
        ]);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return Inertia::render("Admin/Banner/Create");
    }

    public function show($id)
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
        ]);

        $this->bannerRepository->store($request);

        return to_route('admin.banners.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('banner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $banner = Banner::findOrFail($id);

        return Inertia::render('Admin/Banner/Edit', [
            'banner' => $banner,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image',
        ]);

        $banner = Banner::findOrFail($id);

        $this->bannerRepository->update($request, $banner);

        return to_route('admin.banners.index');
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $this->bannerRepository->delete($banner);
    }
}
