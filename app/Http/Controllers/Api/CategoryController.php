<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @group Category
 */
class CategoryController extends Controller
{

    /**
     * Get Categories
     *
     * List all of categories
     *
     * @queryParam page Show the page.Example: 17
     *
     *
     * @response status=200 {
     * "data" : [{"id":1,"name":"Category IV","file":null,"created_at":"2024-01-09T08:17:55.000000Z"},{"id":2,"name":"Prof. Category Kerluke II","file":null,"created_at":"2024-01-09T08:17:55.000000Z"},{"id":3,"name":"Ole Brown","file":null,"created_at":"2024-01-09T08:17:55.000000Z"},{"id":4,"name":"Joshua Hills","file":null,"created_at":"2024-01-09T08:17:55.000000Z"}]
     * }
     */
    public function index()
    {
//        if(!auth()->user()->tokenCan('show-categories')) {
//            abort(403, 'Unauthorized');
//        }
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    /**
     * Post product
     *
     * @bodyParam name string required Name of category. Example: "Clothing"
     * @bodyParam file Name of category. Example: "File-1"
     */
    public function store(CategoryRequest $request): JsonResource
    {
        $data = $request->all();
        if($request->hasFile('file')) {
            $fileName = uniqid() . '.' . $request->file('file')->extension();
            $request->file('file')->storeAs('categories/', $fileName, 'public');
            $data['file'] = $fileName;
        }
        $category = Category::create($data);
        return new CategoryResource($category);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

    public function update(Category $category, CategoryRequest $request): JsonResource
    {
       $category->update($request->all());

       return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
