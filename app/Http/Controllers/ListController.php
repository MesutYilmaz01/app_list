<?php

namespace App\Http\Controllers;

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
     * @param ListRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function get(ListRequest $request)
    {
        try {
            $lists = $this->userListManager->get($request->all());
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
