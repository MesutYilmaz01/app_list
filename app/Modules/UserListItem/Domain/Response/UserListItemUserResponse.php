<?php

namespace App\Modules\UserListItem\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserListItem\Domain\Aggregate\UserListItemAggregate;

class UserListItemUserResponse implements IBaseResponse
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
            "header" => $this->userListItemAggregate->getUserListItemEntity()->header,
            "description" => $this->userListItemAggregate->getUserListItemEntity()->description,
            "status" => $this->userListItemAggregate->getUserListItemEntity()->status,
            "created_at" => $this->userListItemAggregate->getUserListItemEntity()->created_at->toDateTimeString(),
        ];
    }
}
