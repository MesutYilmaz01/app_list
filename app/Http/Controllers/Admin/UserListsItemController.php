<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserListsItem\UserListsItemUpdateRequest;
use App\Http\Requests\Common\UserListsItem\UserListsItemDeleteRequest;
use App\Http\Requests\Common\UserListsItem\UserListsItemShowRequest;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use App\Modules\UserListItem\Domain\Response\UserListItemAdminResponse;
use Exception;
use Illuminate\Http\JsonResponse;

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
            $userListItem = $this->userListItemManager->setResponseType(UserListItemAdminResponse::class)->show($request->list_item_id);
            return response()->json([
                "message" => "List item got successfully.",
                "result" => ["user_list_item" => $userListItem],
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
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
            $userListItemDTO = UserListItemDTO::fromUpdateRequest($request->validated());
            $userListItem = $this->userListItemManager->setResponseType(UserListItemAdminResponse::class)->update($request->list_item_id, $userListItemDTO);
            return response()->json([
                "message" => "User list item updated successfully.",
                "result" => ["user_list_item" => $userListItem],
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
            $this->userListItemManager->delete($request->list_item_id);
            return response()->json(["message" => "User list item deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
