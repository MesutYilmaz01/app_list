<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\UserAuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class UserAuthorityUserResponse implements IBaseResponse
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
                "name" =>  $this->userAuthorityAggregate->getAuthority()["name"],
                "code" =>  $this->userAuthorityAggregate->getAuthority()["code"],
            ],
            "created_at" => $this->userAuthorityAggregate->getUserAuthorityEntity()->created_at->toDateTimeString()

        ];

        return $response;
    }
}
