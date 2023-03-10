<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except(['index', 'show']);
    }

    private function getChildCategoryIds($categoryId)
    {
        $childCategoryIds = Category::where('parent_id', $categoryId)->pluck('id');
        foreach ($childCategoryIds as $childCategoryId) {
            $childCategoryIds = $childCategoryIds->merge($this->getChildCategoryIds($childCategoryId));
        }
        return $childCategoryIds;
    }

    // Posts filtered by all the categories and subcategories
    private function filterByCategoryId($posts, $categoryId)
    {
        $childCategoryIds = $this->getChildCategoryIds($categoryId);
        $categoryIds = $childCategoryIds->push($categoryId);
        return $posts->whereIn('category_id', $categoryIds);
    }


    public function index(Request $request)
    {
        $posts = Post::query();

        if ($request->has('title')) {
            $posts->where('title', 'LIKE', '%' . $request->input('title') . '%');
        }

        if ($request->has('description')) {
            $posts->where('description', 'LIKE', '%' . $request->input('description') . '%');
        }

        if ($request->has('price_from') && $request->has('price_to')) {
            $priceFrom = $request->input('price_from');
            $priceTo = $request->input('price_to');
            $posts->whereBetween('price', [$priceFrom, $priceTo]);
        } elseif ($request->has('price_from')) {
            $priceFrom = $request->input('price_from');
            $posts->where('price', '>=', $priceFrom);
        } elseif ($request->has('price_to')) {
            $priceTo = $request->input('price_to');
            $posts->where('price', '<=', $priceTo);
        }

        if ($request->has('state')) {
            $posts->where('state', 'LIKE', '%' . $request->input('state') . '%');
        }

        if ($request->has('location')) {
            $posts->where('location', 'LIKE', '%' . $request->input('location') . '%');
        }

        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $posts = $this->filterByCategoryId($posts, $categoryId);
        }

        $perPage = $request->has('per_page') ? $request->input('per_page') : 15;
        $currentPage = $request->has('current_page') ? $request->input('current_page') : 1;

        $result = $posts->with('category')->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
        return $result;
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'state' => 'required|string',
            'image_url' => 'required|string',
            'contact' => 'required|string',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required'
        ]);

        $post = Post::create($validatedData);

        return response()->json(['message' => 'Post created successfully', 'data' => $post], 201);
    }

    public function show($id)
    {
        return Post::with('category')->find($id);
    }

    public function update(Request $request, Post $post)
    {
        $post = Post::findOrFail($post);

        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'state' => 'required|string',
            'image_url' => 'required|string',
            'contact' => 'required|string',
            'location' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->update($validatedData);

        return response()->json(['message' => 'Post updated successfully', 'data' => $post], 200);
    }

    public function destroy(Post $post)
    {
        $post = Post::findOrFail($post);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully'], 200);
    }
}
