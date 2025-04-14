<?php

namespace App\Modules\UserListItem\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserListItem\Domain\Aggregate\UserListItemAggregate;

class UserListItemUserListResponse implements IBaseResponse
{
    public function __construct(
        private UserListItemAggregate $userListItemAggregate
    ) {}

    /**
     * Fills userListItemAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [];
        foreach ($this->userListItemAggregate->getUserListItemList() as $userListItem) {
            array_push($response, [
                "id" => $userListItem->id,
                "header" => $userListItem->header,
                "description" => $userListItem->description,
                "status" => $userListItem->status,
                "created_at" => $userListItem->created_at->toDateTimeString(),
            ]);
        }

        return $response;
    }
}
