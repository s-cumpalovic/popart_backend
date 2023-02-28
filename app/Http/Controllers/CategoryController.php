<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    public function __construct()
    {
        // Due to issues on the frontend this middleware is commented for the sake of testing


        // $this->middleware('admin');
    }

    public function deleteCategoryTree()
    {
        $this->children()->each(function ($child) {
            $child->deleteCategoryTree();
        });

        $this->delete();
    }


    public function index()
    {
        $categories = Category::with('children')->get();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->parent_id = $validatedData['parent_id'];
        $category->save();

        return response()->json(['message' => 'Category created successfully'], 201);
    }

    public function show(Category $category)
    {
        $oneCategory = Category::with('children')->find($category);
        return response()->json($oneCategory, 200);
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $category->name = $validatedData['name'];
        $category->parent_id = $validatedData['parent_id'];
        $category->save();

        return response()->json(['message' => 'Category updated successfully'], 200);
    }

    public function destroy(Category $category)
    {
        $category->posts()->delete();
        foreach ($category->children as $child) {
            $this->destroy($child);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
