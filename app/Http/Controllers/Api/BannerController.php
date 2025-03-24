<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function listing()
    {
        $banners = Banner::select('id', 'image')
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'success'       => true,
            'data'          => $banners,
        ]);
    }
}
