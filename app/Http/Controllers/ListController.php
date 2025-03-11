<?php

namespace App\Http\Controllers;

use App\Http\Requests\List\ListLatestRequest;
use App\Http\Requests\List\ListRequest;
use App\Modules\UserList\Application\Manager\UserListManager;
use Exception;

class ListController extends Controller
{
    public function __construct(
        private UserListManager $userListManager
    ) {}

    /**
     * Gets all lists according to given filter attributes.
     * 
     * @param array $filters
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function get(array $filters)
    {
        try {
            return $this->userListManager->get($filters);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Gets all lists according to given filter attributes.
     * 
     * @param ListLatestRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getForLatest(ListLatestRequest $request)
    {
        try {
            $lists = $this->get($request->all());
            return response()->json([
                "message" => "List got successfully.",
                "result" => [
                    "lists" => $lists
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Gets all lists according to given filter attributes.
     * 
     * @param ListLatestRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getOrdinary(ListRequest $request)
    {
        try {
            $lists = $this->get($request->all());
            return response()->json([
                "message" => "List got successfully.",
                "result" => [
                    "lists" => $lists
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
