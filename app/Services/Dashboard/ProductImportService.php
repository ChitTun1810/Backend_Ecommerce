<?php

namespace App\Services\Dashboard;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductType;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProductImportService
{
    protected $rows;
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function store(array $data)
    {
        try {
            DB::beginTransaction();

            $brand    = $this->checkBrandExist($data['brand']);
            $category = $this->checkCategoryExist($data['category']);

            if ($data['sub_category']) {
                $sub_category = $this->checkCategoryExist($data['sub_category'], $category->id);
            }

            if ($data['sub_child']) {
                $sub_child = $this->checkCategoryExist($data['sub_child'], $sub_category->id);
            }

            if ($data['country']) {
                $country = $this->checkCountryExist($data['country']);
            }

            if ($data['product_type']) {
                $productType = $this->checkProductType($data['product_type']);
            }

            $this->checkProductExist($data['sku']);

            $product = new Product([
                "name"            => $data["name"],
                "sku"             => $data["sku"],
                "stocks"          => $data["stocks"],
                "brand_id"        => $brand->id,
                "category_id"     => $category->id,
                "sub_category_id" => $sub_category->id ?? null,
                "sub_child_id"    => $sub_child->id ?? null,
                "product_type_id" => $productType->id ?? null,
                "price"           => $data["price"],
                "description"     => $data["description"],
                "key_information" => $data["key_information"],
                "specification"   => $data["specification"],
                'is_active'       => 1,
                'country_id'      => $country->id ?? null,
            ]);
            DB::commit();
            return $product;
        }
        catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

    }

    protected function checkBrandExist($name): Brand
    {
        $brand = Brand::where("name", $name)->first();

        if ($brand) {
            return $brand;
        }
        else {
            $newBrand = Brand::create([
                'name' => $name,
            ]);
            return $newBrand;
        }
    }


    protected function checkCategoryExist($name, $parent_id = null)
    {
        $category = Category::where('name', $name)->first();

        if ($category) {
            if ($category->parent_id == $parent_id) {
                return $category;
            }
            else {
                throw ValidationException::withMessages(['file' => "Invalid category parent category and sub category at row $this->rows."]);
            }
        }
        else {
            $newCategory = Category::create([
                'name'      => $name,
                'parent_id' => $parent_id,
            ]);

            return $newCategory;
        }
    }

    protected function checkCountryExist($name): Country
    {
        $country = Country::where("name", $name)->first();

        if ($country) {
            return $country;
        }
        else {
            $newCountry = Country::create([
                'name' => $name,
            ]);
            return $newCountry;
        }
    }

    protected function checkProductExist($name)
    {
        $product = Product::where('sku', $name)->get();

        if (count($product) > 1) {
            throw ValidationException::withMessages(['file' => "At row $this->rows, SKU name $name already exists."]);
        }
    }

    protected function checkProductType($name)
    {
        $productType = ProductType::where("name", $name)->first();
        if ($productType) {
            return $productType;
        }
    }
}
