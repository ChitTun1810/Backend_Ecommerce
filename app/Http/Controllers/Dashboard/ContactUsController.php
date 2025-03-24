<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\ContactUsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactUsController extends Controller
{
    public function __construct(public ContactUsService $contactUsService)
    {

    }
    public function index(Request $request)
    {
        $contacts = $this->contactUsService->listing($request);

        return Inertia::render('Admin/Contact/Index', [
            'contacts' => $contacts,
        ]);
    }

    public function show($id)
    {
        $contact = $this->contactUsService->show($id);
        return Inertia::render('Admin/Contact/Show', [
            'contact' => $contact,
        ]);
    }

    public function destroy($id)
    {
        $this->contactUsService->delete($id);
    }
}
