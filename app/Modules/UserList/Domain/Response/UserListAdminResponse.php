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
                "id" => $this->userListAggregate->getCategory()["id"],
                "name" => $this->userListAggregate->getCategory()["name"],
            ],
            "items" => []
        ];

        foreach ($this->userListAggregate->getUserListItems() as $userListItem) {
            array_push($response["items"], [
                "id" => $userListItem["id"],
                "header" => $userListItem["header"],
                "description" => $userListItem["description"],
                "status" => $userListItem["status"],
                "created_at" => $userListItem["created_at"],
                "updated_at" => $userListItem["updated_at"],
                "deleted_at" => isset($userListItem["deleted_at"]) ? $userListItem["deleted_at"] : null,
            ]);
        }

        foreach ($this->userListAggregate->getComments() as $comment) {
            array_push($response["comments"], [
                "id" => $comment["id"],
                "comment" => $comment["comment"],
                "status" => $userListItem["status"],
                "approved_at" => isset($comment["approved_at"]) ? $comment["approved_at"] : null,
                "created_at" => $comment["created_at"],
                "updated_at" => $comment["updated_at"],
            ]);
        }

        return $response;
    }
}
