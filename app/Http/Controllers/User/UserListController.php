<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UserList\UserListDeleteRequest;
use App\Http\Requests\Common\UserList\UserListGetAllForUserRequest;
use App\Http\Requests\Common\UserList\UserListGetOneForUserRequest;
use App\Http\Requests\User\UserList\UserListCreateRequest;
use App\Http\Requests\User\UserList\UserListUpdateRequest;
use App\Modules\Authority\Domain\Enums\AuthorityType;
use App\Modules\Shared\Events\UserList\UserListCreatedEvent;
use App\Modules\Shared\Events\UserList\UserListDeletedEvent;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserList\Domain\Entities\UserListEntity;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserList\Domain\Response\UserListUserResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
            Gate::authorize('isAuthorized', [new UserListEntity(), $request->list_id, AuthorityType::SHOW]);
            $userList = $this->userListManager->setResponseType(UserListUserResponse::class)->show($request->list_id);
            return response()->json([
                "message" => "List got successfully.",
                "result" => $userList,
            ], 200);
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
    public function create(UserListCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $userListDTO = UserListDTO::fromCreateRequest($request->validated());
            $userList = $this->userListManager->create($userListDTO);
            $userListItemDTOs = UserListItemDTO::forMultiplefromRequest($request->validated(), $userList->id);
            UserListCreatedEvent::dispatch($userListItemDTOs);

            DB::commit();

            $userList = $this->userListManager->setResponseType(UserListUserResponse::class)->show($userList->id);

            return response()->json([
                "message" => "List added with it's item successfully.",
                "result" => $userList
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], $e->getCode());
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
        try {
            Gate::authorize('isAuthorized', [new UserListEntity(), $request->list_id, AuthorityType::UPDATE]);

            $userListDTO = UserListDTO::fromUpdateRequest($request->validated());
            $userList = $this->userListManager->setResponseType(UserListUserResponse::class)->update($request->list_id, $userListDTO);
            return response()->json([
                "message" => "User list updated successfully.",
                "result" => $userList
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
        try {
            Gate::authorize('isAuthorized', [new UserListEntity(), $request->list_id, AuthorityType::DELETE]);

            $this->userListManager->delete($request->list_id);
            UserListDeletedEvent::dispatch($request->list_id);
            return response()->json(["message" => "User list deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
