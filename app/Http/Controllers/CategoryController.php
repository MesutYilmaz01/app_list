<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Modules\Category\Application\Manager\CategoryManager;

class CategoryController extends Controller
{
    private CategoryManager $categoryManager;

    public function __construct(CategoryManager $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    public function getAll()
    {
        return $this->categoryManager->getAll();
    }

    public function show(CategoryShowRequest $request)
    {
        return Category::where('id', $request->id)->first();
    }

    public function create(CategoryCreateRequest $request)
    {
        $category = Category::create([
            'name' => $request->name
        ]);

        if(!$category)
        {
            return response()->json([
                'status' => 'fail',
                'message' => 'category cant created'
            ]);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'category created'
        ]);
    }

    public function update()
    {
        //Todo
    }

    public function delete()
    {
        //Todo
    }
}
