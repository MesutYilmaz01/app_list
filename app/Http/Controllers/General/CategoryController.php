<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Modules\Category\Application\Manager\CategoryManager;
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
            $categories = $this->categoryManager->getAll();
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
        $categories = $this->categoryManager->getPopulars();
        try {
           
            return response()->json([
                "message" => "Categories got successfully.",
                "result" => ["categories" => $categories]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
