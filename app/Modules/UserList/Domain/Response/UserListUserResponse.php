<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Interfaces\Entities\IEntity;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListUserResponse
{
    public function __construct(private readonly UserListAggregate $aggregate)
    {
    }

    private array $fill = [];

    /**
     * @return void
     */
    public function fill(): self
    {
        $response = [
            "header" => $this->aggregate->getUserListItems()->header,
            "description" => $this->aggregate->getUserListItems()->description,
            "created_at" => $this->aggregate->getUserListItems()->created_at->toDateTimeString(),
            "is_public" => $this->aggregate->getUserListItems()->is_public,
            "status" => $this->aggregate->getUserListItems()->status,
            "category" => [
                "id" => $this->aggregate->getUserListItems()->category->id,
                "name" => $this->aggregate->getUserListItems()->category->name,
            ],
            "items" => []
        ];

        foreach ($this->aggregate->getUserListItems()->userListsItems as $userLitsItem) {
            array_push($response["items"], [
                "id" => $userLitsItem->id,
                "header" => $userLitsItem->header,
                "description" => $userLitsItem->description,
                "status" => $userLitsItem->status,
            ]);
        }

        $this->fill = $response;
        return $this;
    }

    public function getResponse(): array
    {
        return $this->fill;
    }

}
