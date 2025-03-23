<?php

namespace App\Modules\UserListItem\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserListItem\Domain\Aggregate\UserListItemAggregate;

class UserListItemAdminResponse implements IBaseResponse
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
        return [
            "id" => $this->userListItemAggregate->getUserListItemEntity()->id,
            "user_list_id" => $this->userListItemAggregate->getUserListItemEntity()->user_list_id,
            "header" => $this->userListItemAggregate->getUserListItemEntity()->header,
            "description" => $this->userListItemAggregate->getUserListItemEntity()->description,
            "status" => $this->userListItemAggregate->getUserListItemEntity()->status,
            "created_at" => $this->userListItemAggregate->getUserListItemEntity()->created_at->toDateTimeString(),
            "updated_at" => $this->userListItemAggregate->getUserListItemEntity()->updated_at->toDateTimeString(),
            "deleted_at" => $this->userListItemAggregate->getUserListItemEntity()->deleted_at ? $$this->userListItemAggregate->getUserListItemEntity()->deleted_at->toDateTimeString() : null,
        ];
    }
}
