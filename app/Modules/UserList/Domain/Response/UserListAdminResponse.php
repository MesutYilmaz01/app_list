<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListAdminResponse implements IBaseResponse
{
    public function __construct(
        private UserListAggregate $userListAggregate
    ) {}

    /**
     * Fills userListAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [
            "id" => $this->userListAggregate->getUserListEntity()->id,
            "user_id" => $this->userListAggregate->getUserListEntity()->user_id,
            "header" => $this->userListAggregate->getUserListEntity()->header,
            "description" => $this->userListAggregate->getUserListEntity()->description,
            "status" => $this->userListAggregate->getUserListEntity()->status,
            "is_public" => $this->userListAggregate->getUserListEntity()->is_public,
            "created_at" => $this->userListAggregate->getUserListEntity()->created_at->toDateTimeString(),
            "updated_at" => $this->userListAggregate->getUserListEntity()->updated_at->toDateTimeString(),
            "deleted_at" => $this->userListAggregate->getUserListEntity()->deleted_at ? $this->userListAggregate->getUserListEntity()->deleted_at->toDateTimeString() : null,
            "category" => [
                "id" => $this->userListAggregate->getUserListEntity()->category->id,
                "name" => $this->userListAggregate->getUserListEntity()->category->name,
            ],
            "items" => []
        ];

        foreach ($this->userListAggregate->getUserListEntity()->userListsItems as $userListItem) {
            array_push($response["items"], [
                "id" => $userListItem->id,
                "header" => $userListItem->header,
                "description" => $userListItem->description,
                "status" => $userListItem->status,
                "created_at" => $userListItem->created_at->toDateTimeString(),
                "updated_at" => $userListItem->updated_at->toDateTimeString(),
                "deleted_at" => $this->userListAggregate->getUserListEntity()->deleted_at ? $userListItem->deleted_at->toDateTimeString() : null,
            ]);
        }

        return $response;
    }
}
