<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{

    public function __construct(public ContactUsService $contactUsService)
    {
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'phone'   => 'required',
            'subject' => 'required|string|min:8',
            'message' => 'required|string|min:8',
        ]);

        $this->contactUsService->store($request);
        return response()->json([
            'success' => true,
            'message' => 'successful.',
        ]);
    }
}
