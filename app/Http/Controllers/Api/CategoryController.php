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


class CategoryController extends Controller
{
    public function index()
    {
//        if(!auth()->user()->tokenCan('show-categories')) {
//            abort(403, 'Unauthorized');
//        }
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    public function show(Category $category): JsonResource
    {
        return new CategoryResource($category);
    }

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
