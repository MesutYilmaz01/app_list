<?php

namespace App\Modules\UserListItem\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserListItem\Domain\Aggregate\UserListItemAggregate;

class UserListItemAdminListResponse implements IBaseResponse
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
                "user_list_id" => $userListItem->user_list_id,
                "header" => $userListItem->header,
                "description" => $userListItem->description,
                "status" => $userListItem->status,
                "created_at" => $userListItem->created_at->toDateTimeString(),
                "updated_at" => $userListItem->updated_at->toDateTimeString(),
                "deleted_at" => $userListItem->deleted_at ? $userListItem->deleted_at->toDateTimeString() : null,
            ]);
        }

        return $response;
    }
}
