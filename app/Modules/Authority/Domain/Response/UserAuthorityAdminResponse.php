<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\UserAuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class UserAuthorityAdminResponse implements IBaseResponse
{
    public function __construct(
        private UserAuthorityAggregate $userAuthorityAggregate
    ) {}

    /**
     * Fills userAuthorityAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [
            "id" => $this->userAuthorityAggregate->getUserAuthorityEntity()->id,
            "owner_user" => [
                "id" =>  $this->userAuthorityAggregate->getOwnerUser()["id"],
                "name" =>  $this->userAuthorityAggregate->getOwnerUser()["name"],
                "surname" =>  $this->userAuthorityAggregate->getOwnerUser()["surname"],
            ],
            "authorized_user" => [
                "id" =>  $this->userAuthorityAggregate->getAuthorizedUser()["id"],
                "name" =>  $this->userAuthorityAggregate->getAuthorizedUser()["name"],
                "surname" =>  $this->userAuthorityAggregate->getAuthorizedUser()["surname"],
            ],
            "user_list" => [
                "id" =>  $this->userAuthorityAggregate->getUserList()["id"],
                "header" =>  $this->userAuthorityAggregate->getUserList()["header"],
            ],
            "authority" => [
                "id" =>  $this->userAuthorityAggregate->getAuthority()["id"],
                "code" =>  $this->userAuthorityAggregate->getAuthority()["code"],
            ],
            "created_at" => $this->userAuthorityAggregate->getUserAuthorityEntity()->created_at->toDateTimeString(),
            "updated_at" => $this->userAuthorityAggregate->getUserAuthorityEntity()->updated_at->toDateTimeString(),
            "deleted_at" => $this->userAuthorityAggregate->getUserAuthorityEntity()->deleted_at ? $$this->userAuthorityAggregate->getUserAuthorityEntity()->deleted_at->toDateTimeString() : null,

        ];

        return $response;
    }
}
