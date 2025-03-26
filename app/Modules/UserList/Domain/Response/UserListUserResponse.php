<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListUserResponse implements IBaseResponse
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
            "header" => $this->userListAggregate->getUserListEntity()->header,
            "description" => $this->userListAggregate->getUserListEntity()->description,
            "status" => $this->userListAggregate->getUserListEntity()->status,
            "is_public" => $this->userListAggregate->getUserListEntity()->is_public,
            "created_at" => $this->userListAggregate->getUserListEntity()->created_at->toDateTimeString(),
            "category" => [
                "id" => $this->userListAggregate->getCategory()["id"],
                "name" => $this->userListAggregate->getCategory()["name"],
            ],
            "editable" => $this->userListAggregate->getUserListEntity()->user_id == $this->userListAggregate->getUserEntity()?->id,
            "items" => []
        ];

        foreach ($this->userListAggregate->getUserListItems() as $userListItem) {
            array_push($response["items"], [
                "id" => $userListItem["id"],
                "header" => $userListItem["header"],
                "description" => $userListItem["description"],
                "status" => $userListItem["status"]
            ]);
        }

        return $response;
    }
}
