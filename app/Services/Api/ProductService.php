<?php

namespace App\Services\Api;

use Exception;
use App\Models\Product;
use App\Models\ProductInquiry;
use App\Models\SaveProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProductService
{
    public $query;

    protected $selectColumns = [
        'products.id',
        'products.name',
        'products.sku',
        'products.stocks',
        'products.brand_id',
        'products.country_id',
        'products.category_id',
        'products.sub_category_id',
        'products.sub_child_id',
        'products.product_type_id',
        'products.price',
        'products.description',
        'products.key_information',
        'products.is_active',
        'products.specification',
        'products.is_specification',
        'products.created_at',
    ];

    public function listing(Request $request)
    {
        $this->query = $this->_getListing();

        if (isset($request->keyword)) {
            $this->query = $this->query->where('products.name', 'like', "%{$request->keyword}%");
        }

        if (isset($request->categories)) {
            $this->query = $this->query->whereIn('category_id', $request->categories)
                ->orWhereIn('sub_category_id', $request->categories)
                ->orWhereIn('sub_child_id', $request->categories);
        }

        if (isset($request->brands)) {
            $this->query = $this->query->whereIn('brand_id', $request->brands);
        }

        if (isset($request->countries)) {
            $this->query = $this->query->whereIn('country_id', $request->countries);
        }

        if (isset($request->types)) {
            $this->query = $this->query
                ->whereIn('products.product_type_id', $request->types)
                ->orderByRaw('ISNULL(products.product_type_id), products.product_type_id ASC');
        }

        $product = $this->query->active()
            ->orderBy('products.created_at', 'desc')
            ->paginate($request->limit);
        return $product;
    }

    /**
     * fix later
     */
    public function newArrival(Request $request)
    {
        $this->query = $this->_getListing();

        $product = $this->query
            ->newArrival()
            ->active()
            ->orderBy('products.id', 'desc')
            ->paginate($request->limit);

        return $product;
    }

    public function detail($id)
    {
        $product = $this->_getDetail($id);

        if (!$product) {
            throw new Exception('Product Not Found');
        }

        $query = Product::with(['images', 'brand']);

        if (isset($product->sub_child_id)) {
            $query = $query->where('sub_child_id', $product->sub_child_id);
        }

        if (isset($product->sub_category_id)) {
            $query = $query->where('sub_category_id', $product->sub_category_id);
        }

        if (isset($product->category_id)) {
            $query = $query->where('category_id', $product->category_id);
        }

        $related = $query
            ->latest('id')
            ->limit(6)
            ->get();

        return [$product, $related];
    }

    public function favouriteProducts(Request $request)
    {
        $this->query = Product::select($this->selectColumns)
            ->selectRaw('IFNULL(save_products.saved, 0) as fav')
            ->leftJoin('save_products', 'save_products.product_id', '=', 'products.id')
            ->with(['images', 'brand:id,name,image'])
            ->where('save_products.customer_id', Auth::id());

        $product = $this->query->active()
            ->orderBy('products.id', 'desc')
            ->paginate($request->limit);

        return $product;
    }

    public function saveToggle($id)
    {
        $product = $this->_getDetail($id);

        if (!$product) {
            throw new Exception('Product Not Found');
        }

        $checkProductInSavePost = SaveProduct::where('customer_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if (!$checkProductInSavePost) {
            $newSavePost              = new SaveProduct();
            $newSavePost->product_id  = $id;
            $newSavePost->customer_id = Auth::id();
            $newSavePost->saved       = 1;
            $newSavePost->save();
        }
        else {
            $checkProductInSavePost->delete();
        }
    }

    private function _getDetail($id)
    {
        $product = Product::select($this->selectColumns)
            ->selectRaw('IFNULL(save_products.saved, 0) as fav')
            ->leftJoin('save_products', function ($s) {
                $s->on('save_products.product_id', '=', 'products.id');
                $s->where('save_products.customer_id', '=', Auth::id());
            })
            ->with([
                'brand:id,name,image',
                'category:id,name,image',
                'subCategory:id,name,image',
                'subChild:id,name,image',
                'userManualLinks',
                'country',
                'images',
                'productType',
            ])
            ->active()
            ->where('products.id', $id)
            ->first();

        return $product;
    }

    private function _getListing()
    {
        return Product::select($this->selectColumns)
            ->selectRaw('IFNULL(save_products.saved, 0) as fav')
            ->leftJoin('save_products', function ($s) {
                $s->on('save_products.product_id', '=', 'products.id');
                $s->where('save_products.customer_id', '=', Auth::id());
            })
            ->with(['images', 'brand:id,name,image', 'productType:id,name']);
    }

    public function searchProduct(Request $request)
    {
        $query = Product::select('id', 'name', 'price')
            ->with('images');

        if (isset($request->keyword)) {
            $query = $query->where('name', 'like', "%{$request->keyword}%");
        }

        $result = $query
            ->active()
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return $result;
    }

    public function sendInquiry(Request $request)
    {
        $result = ProductInquiry::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'product_id'  => $request->product_id,
            'content'     => $request->content,
            'customer_id' => Auth::id(),
        ]);

        return $result;
    }

}
