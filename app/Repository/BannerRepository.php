<?php

namespace App\Repository;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerRepository {
    public function listing(Request $request)
    {
        $banner = Banner::orderBy('id', 'desc')
            ->paginate($request->limit ?? 10);

        return $banner;
    }

    public function store(Request $request)
    {
        $image = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('banners');
        }

        $banner = Banner::create([
            'image' => $image,
        ]);

        return $banner;
    }

    public function update(Request $request, Banner $banner)
    {
        $image = $banner?->image;
        if ($request->hasFile('image')) {
            if ($image) {
                Storage::delete($banner->image);
            }
            $image = $request->file('image')->store('banners');
        }

        $banner->update([
            'image' => $image,
        ]);

        return $banner;
    }

    public function delete(Banner $banner)
    {
        $image = $banner?->image;
        if ($image) {
            Storage::delete($banner->image);
        }
        $banner->delete();
    }
}
