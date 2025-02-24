<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserList\UserListCreateRequest;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserListItem\Application\Manager\UserListItemManager;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;
use Exception;
use Illuminate\Support\Facades\DB;

class UserListController extends Controller
{
    private UserListManager $userListManager;
    private UserListItemManager $userListItemManager;

    public function __construct(UserListManager $userListManager, UserListItemManager $userListItemManager)
    {
        $this->userListManager = $userListManager;
        $this->userListItemManager = $userListItemManager;
    }

    public function create(UserListCreateRequest $request)
    {
        try{
            DB::beginTransaction();

            $userListDTO = UserListDTO::fromCreateRequest($request);
            $userList = $this->userListManager->create($userListDTO);
            $userListItemDTOs = UserListItemDTO::forMultiplefromRequest($request, $userList->id);
            $userListItems = $this->userListItemManager->create($userListItemDTOs);

            DB::commit();

            return response()->json([
                "message" => "List item added with it's item successfully.",
                "user_list" => $userList,
                "user_list_items" => $userListItems
            ],201);

            
        } catch(Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
