<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserList\UserListCreateRequest;
use App\Http\Requests\UserList\UserListGetAllForUserRequest;
use App\Http\Requests\UserList\UserListGetOneForUserRequest;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use Exception;
use Illuminate\Support\Facades\DB;

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
    public function getAllForUser(UserListGetAllForUserRequest $request)
    {
        try {
            $userLists = $this->userListManager->getAllForUser($request->user_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => [
                    "user_lists" => $userLists
                ],
            ], 201);
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
    public function show(UserListGetOneForUserRequest $request)
    {
        try {
            $userListsAggregate = $this->userListManager->show($request->list_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => $userListsAggregate->toArray(),
            ], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Creates a list with sub items according to given data
     * 
     * @param UserListCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(UserListCreateRequest $request)
    {
        try {
            DB::beginTransaction();

            $userListDTO = UserListDTO::fromCreateRequest($request);
            $userList = $this->userListManager->create($userListDTO);
            $userListItemDTOs = UserListItemDTO::forMultiplefromRequest($request, $userList->id);
            $userListItems = $this->userListItemManager->create($userListItemDTOs);

            DB::commit();

            return response()->json([
                "message" => "List item added with it's item successfully.",
                "result" => [
                    "user_list" => array_merge($userList, ["items" => $userListItems]),
                ],
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
