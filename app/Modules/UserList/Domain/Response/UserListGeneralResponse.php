<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListGeneralResponse implements IBaseResponse
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
            "header" => $this->userListAggregate->getUserListEntity()->header,
            "description" => $this->userListAggregate->getUserListEntity()->description,
            "created_at" => $this->userListAggregate->getUserListEntity()->created_at->toDateTimeString(),
            "category" => [
                "id" => $this->userListAggregate->getUserListEntity()->category->id,
                "name" => $this->userListAggregate->getUserListEntity()->category->name,
            ],
            "items" => []
        ];

        foreach ($this->userListAggregate->getUserListItems() as $userListItem) {
            array_push($response["items"], [
                "header" => $userListItem["header"],
                "description" => $userListItem["description"]
            ]);
        }

        return $response;
    }
}
