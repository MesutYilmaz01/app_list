<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserList\UserListUpdateRequest;
use App\Http\Requests\Common\UserList\UserListDeleteRequest;
use App\Http\Requests\Common\UserList\UserListGetAllForUserRequest;
use App\Http\Requests\Common\UserList\UserListGetOneForUserRequest;
use App\Modules\Shared\Events\UserList\UserListDeletedEvent;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

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
            $userListsAggregate = $this->userListManager->show($request->list_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => $userListsAggregate->toArray(),
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
    
    /**
     * Updates a user list according to given id
     * 
     * @param UserListUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(UserListUpdateRequest $request): JsonResponse
    {
        Gate::authorize('isOwner', [new UserListEntity(), $request->list_id]);
        
        try {
            $userListDTO = UserListDTO::fromUpdateRequest($request);
            $userList = $this->userListManager->update($request->list_id, $userListDTO);
            return response()->json([
                "message" => "User list updated successfully.",
                "result" => ["user_list" => $userList]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a user list according to given id
     * 
     * @param UserListDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(UserListDeleteRequest $request): JsonResponse
    {
        Gate::authorize('isOwner', [new UserListEntity(), $request->list_id]);
        
        try {
            $this->userListManager->delete($request->list_id);
            UserListDeletedEvent::dispatch($request->list_id);
            return response()->json(["message" => "User list deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
