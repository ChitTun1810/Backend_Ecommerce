<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::where('name', '!=', 'guest')
        ->where("email", '!=', "guest@gmail.com")
        ->latest('id')->paginate(10);
        return Inertia::render("Admin/Customer/Index", [
            'customers' => $customers,
        ]);
    }

    public function show($id)
    {
        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer = Customer::find($id);
        return Inertia::render("Admin/Customer/Show", [
            'customer' => $customer,
        ]);
    }
}
