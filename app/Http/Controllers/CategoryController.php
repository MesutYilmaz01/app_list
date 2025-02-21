<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryDeleteRequest;
use App\Http\Requests\Category\CategoryShowRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Modules\Category\Application\Manager\CategoryManager;
use Exception;

class CategoryController extends Controller
{
    private CategoryManager $categoryManager;

    public function __construct(CategoryManager $categoryManager)
    {
        $this->categoryManager = $categoryManager;
    }

    public function getAll()
    {
        try {
            $categories = $this->categoryManager->getAll();
            return response()->json($categories, 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function show(CategoryShowRequest $request)
    {
        try {
            $category = $this->categoryManager->getById($request->id);
            return response()->json($category, 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function create(CategoryCreateRequest $request)
    {
        try {
            $category = $this->categoryManager->create($request->all());
            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function update(CategoryUpdateRequest $request)
    {
        try {
            $category = $this->categoryManager->update($request->id, $request->except("id"));
            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    public function delete(CategoryDeleteRequest $request)
    {
        try {
            $this->categoryManager->delete($request->id);
            return response()->json(["message" => "Category deletion is successfuly completed."], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
