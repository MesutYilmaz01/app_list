<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\UserAuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class UserAuthorityUserListResponse implements IBaseResponse
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
        $response = [];
        foreach ($this->userAuthorityAggregate->getUserAuthorityList() as $userAuthority) {
            array_push($response, [
                "id" => $userAuthority->id,
                "owner_user" => [
                    "id" =>  $userAuthority->ownerUser->id,
                    "name" => $userAuthority->ownerUser->name,
                    "surname" =>  $userAuthority->ownerUser->surname,
                ],
                "authorized_user" => [
                    "id" =>   $userAuthority->authorizedUser->id,
                    "name" =>  $userAuthority->authorizedUser->name,
                    "surname" =>  $userAuthority->authorizedUser->surname,
                ],
                "user_list" => [
                    "id" =>  $userAuthority->userList->id,
                    "header" =>  $userAuthority->userList->header,
                ],
                "authority" => [
                    "code" => $userAuthority->authority->code,
                ],
                "created_at" => $userAuthority->created_at->toDateTimeString()
            ]);
        }

        return $response;
    }
}
