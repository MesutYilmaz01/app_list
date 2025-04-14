<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CategoryCreateRequest;
use App\Http\Requests\Admin\Category\CategoryDeleteRequest;
use App\Http\Requests\Admin\Category\CategoryShowRequest;
use App\Http\Requests\Admin\Category\CategoryUpdateRequest;
use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\Response\CategoryAdminListResponse;
use App\Modules\Category\Domain\Response\CategoryAdminResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryManager $categoryManager
    ) {}

    /**
     * Gets all category data
     * 
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getAll(): JsonResponse
    {
        try {
            $categories = $this->categoryManager->setResponseType(CategoryAdminListResponse::class)->getAll();
            return response()->json([
                "message" => "Categories got successfully.",
                "result" => ["categories" => $categories]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
    
    /**
     * Gets popular categories data
     * 
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getPopulars(): JsonResponse
    {
        try {
            $categories = $this->categoryManager->setResponseType(CategoryAdminListResponse::class)->getPopulars();
            return response()->json([
                "message" => "Categories got successfully.",
                "result" => ["categories" => $categories]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Gets category according to id
     * 
     * @param CategoryShowRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function show(CategoryShowRequest $request): JsonResponse
    {
        try {
            $category = $this->categoryManager->setResponseType(CategoryAdminResponse::class)->getById($request->category_id);
            return response()->json([
                "message" => "Category got successfully.",
                "result" => ["categories" => $category]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Creates a category 
     * 
     * @param CategoryCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(CategoryCreateRequest $request): JsonResponse
    {
        try {
            $categoryDTO = CategoryDTO::fromCreateRequest($request->validated());
            $category = $this->categoryManager->create($categoryDTO);

            $category = $this->categoryManager->setResponseType(CategoryAdminResponse::class)->getById($category->id);
            return response()->json([
                "message" => "Category created successfully.",
                "result" => ["categories" => $category]
            ], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Updates a category according to given id
     * 
     * @param CategoryUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(CategoryUpdateRequest $request): JsonResponse
    {
        try {
            $categoryDTO = CategoryDTO::fromUpdateRequest($request->validated());
            $category = $this->categoryManager->update($request->category_id, $categoryDTO);

            $category = $this->categoryManager->setResponseType(CategoryAdminResponse::class)->getById($category->id);
            return response()->json([
                "message" => "Category updated successfully.",
                "result" => ["categories" => $category]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a category according to given id
     * 
     * @param CategoryDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(CategoryDeleteRequest $request): JsonResponse
    {
        try {
            $this->categoryManager->delete($request->category_id);
            return response()->json(["message" => "Category deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
