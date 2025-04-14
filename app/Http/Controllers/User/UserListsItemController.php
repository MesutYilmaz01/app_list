<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UserListsItem\UserListsItemDeleteRequest;
use App\Http\Requests\Common\UserListsItem\UserListsItemShowRequest;
use App\Http\Requests\User\UserListsItem\UserListsItemCreateRequest;
use App\Http\Requests\User\UserListsItem\UserListsItemUpdateRequest;
use App\Modules\Authority\Domain\Enums\AuthorityType;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use App\Modules\UserListItem\Domain\Response\UserListItemUserResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class UserListsItemController extends Controller
{
    public function __construct(
        private UserListItemManager $userListItemManager
    ) {}

    /**
     * Gets a list item according to given id
     *
     * @param UserListsItemShowRequest $request
     * @return JsonRespone
     *
     * @throws Exception
     */
    public function show(UserListsItemShowRequest $request): JsonResponse
    {
        try {
            Gate::authorize('isOwnerListItem', [new UserListsItemEntity(), $request->list_item_id, AuthorityType::SHOW]);
            $userListItem = $this->userListItemManager->setResponseType(UserListItemUserResponse::class)->show($request->list_item_id);
            return response()->json([
                "message" => "List item got successfully.",
                "result" => $userListItem,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Creates a list with sub items according to given data
     * 
     * @param UserListsItemCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(UserListsItemCreateRequest $request): JsonResponse
    {
        Gate::authorize('isOwnerUserList', [new UserListsItemEntity(), $request->user_list_id]);

        try {
            DB::beginTransaction();

            $userListItemDTO = UserListItemDTO::fromRequest($request->validated());
            $userListItem = $this->userListItemManager->setResponseType(UserListItemUserResponse::class)->create($userListItemDTO);

            DB::commit();

            return response()->json([
                "message" => "List item added successfully.",
                "result" => $userListItem,
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Updates a user list according to given id
     * 
     * @param UserListsItemUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(UserListsItemUpdateRequest $request): JsonResponse
    {
        try {
            Gate::authorize('isOwnerListItem', [new UserListsItemEntity(), $request->list_item_id, AuthorityType::UPDATE]);
            $userListItemDTO = UserListItemDTO::fromUpdateRequest($request->validated());
            $userListItem = $this->userListItemManager->setResponseType(UserListItemUserResponse::class)->update($request->list_item_id, $userListItemDTO);
            return response()->json([
                "message" => "User list item updated successfully.",
                "result" => $userListItem,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a user list according to given id
     * 
     * @param UserListsItemDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(UserListsItemDeleteRequest $request): JsonResponse
    {
        try {
            Gate::authorize('isOwnerListItem', [new UserListsItemEntity(), $request->list_item_id, AuthorityType::DELETE]);
            $this->userListItemManager->delete($request->list_item_id);
            return response()->json(["message" => "User list item deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
