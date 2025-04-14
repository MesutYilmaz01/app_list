<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Modules\Category\Application\Manager\CategoryManager;
use App\Modules\Category\Domain\Response\CategoryGeneralListResponse;
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
            $categories = $this->categoryManager->setResponseType(CategoryGeneralListResponse::class)->getAll();
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
            $categories = $this->categoryManager->setResponseType(CategoryGeneralListResponse::class)->getPopulars();
            return response()->json([
                "message" => "Categories got successfully.",
                "result" => ["categories" => $categories]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
