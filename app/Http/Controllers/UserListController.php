<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserList\UserListCreateRequest;
use App\Modules\UserList\Application\Manager\UserListManager;
use App\Modules\UserList\Domain\DTO\UserListDTO;
use App\Modules\UserListItem\Domain\DTO\UserListItemDTO;

class UserListController extends Controller
{
    private UserListManager $userListManager;

    public function __construct(UserListManager $userListManager)
    {
        $this->userListManager = $userListManager;
    }

    public function create(UserListCreateRequest $request)
    {
        $userListDTO = UserListDTO::fromCreateRequest($request);
        $userListItemDTOs = UserListItemDTO::forMultiplefromRequest($request);

        $userList = $this->userListManager->create($userListDTO);
        dd($userList);
        //dd($userList);
    }
}
