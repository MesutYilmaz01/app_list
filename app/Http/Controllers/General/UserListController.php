<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UserList\UserListGetAllForUserRequest;
use App\Http\Requests\Common\UserList\UserListGetOneForUserRequest;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\Response\UserListGeneralResponse;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;
use Illuminate\Http\JsonResponse;

class UserListController extends Controller
{
    public function __construct(
        private UserListManager $userListManager,
        private UserListItemManager $userListItemManager
    ) {}

    /**
     * Gets all lists according to given user id
     *
     * @param UserListGetAllForUserRequest $request
     * @return JsonRespone
     *
     * @throws Exception
     */
    public function getAllForUser(UserListGetAllForUserRequest $request): JsonResponse
    {
        try {
            $userLists = $this->userListManager->getAllForUser($request->user_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => [
                    "user_lists" => $userLists
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Gets a list with sub items according to given list id
     *
     * @param UserListGetOneForUserRequest $request
     * @return JsonRespone
     *
     * @throws Exception
     */
    public function show(UserListGetOneForUserRequest $request): JsonResponse
    {
        try {
            $userList = $this->userListManager->setResponseType(UserListGeneralResponse::class)->show($request->list_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => $userList,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
}