<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct(public CategoryRepository $categoryRepository)
    {
    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = $this->categoryRepository->listing($request);
        return Inertia::render("Admin/Category/Index", [
            "categories" => $categories,
        ]);
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all();

        return Inertia::render("Admin/Category/Create", [
            "categories" => $categories,
        ]);
    }

    public function show($id)
    {
        abort_if(Gate::denies('category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category        = Category::find($id);
        $childCategories = $this->categoryRepository->getByParent($id);

        return Inertia::render("Admin/Category/Show", [
            'category'        => $category,
            'childCategories' => $childCategories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $this->categoryRepository->store($request);

        return to_route('admin.categories.index');
    }

    public function edit($id)
    {
        abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $category       = Category::findOrFail($id);
        $selectCategory = Category::whereNot('id', $id)->get();


        return Inertia::render('Admin/Category/Edit', [
            'category'   => $category,
            'categories' => $selectCategory,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $category = Category::findOrFail($id);

        $this->categoryRepository->update($request, $category);

        return to_route('admin.categories.index');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $this->categoryRepository->delete($category);
        // return to_route('admin.categories.index');
    }

    public function filterByParent(Request $request)
    {
        $id       = $request->id;
        $category = $this->categoryRepository->getByParent($id);

        return response()->json([
            'data'    => $category,
            'success' => true,
        ], 200);
    }
}
