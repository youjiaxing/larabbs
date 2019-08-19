<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request)
    {
        $topics = $category->topics()->withOrder($request->order)->paginate(20);
        return view('topics.index', compact('topics', 'category'));
    }
}
