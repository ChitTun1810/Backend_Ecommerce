<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Number;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $customer = Customer::where('name', '!=', 'guest')
            ->where("email", '!=', "guest@gmail.com")->count();
        $order    = Order::today()->count();
        $product  = Product::count();
        $brand    = Brand::count();

        $counting = [
            "customers" => $customer,
            "orders"    => $order,
            "products"  => $product,
            "brands"    => $brand,
        ];
        return Inertia::render("Dashboard", [
            "counting" => $counting,
        ]);
    }
}
