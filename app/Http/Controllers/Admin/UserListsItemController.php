<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserListsItem\UserListsItemUpdateRequest;
use App\Http\Requests\Common\UserListsItem\UserListsItemDeleteRequest;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserListsItemController extends Controller
{
    public function __construct(
        private UserListItemManager $userListItemManager
    ) {}
    
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
        Gate::authorize('isOwner', [new UserListsItemEntity(), $request->list_item_id]);

        try {
            $userListDTO = UserListItemDTO::fromUpdateRequest($request->validated());
            $userListItem = $this->userListItemManager->update($request->list_item_id, $userListDTO);
            return response()->json([
                "message" => "User list item updated successfully.",
                "result" => ["list_item" => $userListItem]
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
        Gate::authorize('isOwner', [new UserListsItemEntity(), $request->list_item_id]);

        try {
            $this->userListItemManager->delete($request->list_item_id);
            return response()->json(["message" => "User list item deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
