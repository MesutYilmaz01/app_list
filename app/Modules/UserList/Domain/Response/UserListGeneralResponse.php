<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Interfaces\Entities\IEntity;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListGeneralResponse extends BaseResponse
{
    public function __construct(private readonly UserListAggregate $aggregate)
    {
    }

    private array $fill = [];

    /**
     * Takes a IEntity and add it response.
     *
     * @param IEntity $entity
     * @return IEntity
     */
    public function fill(): self
    {
        $response = [
            "header" => $this->aggregate->getUserListItems()->header,
            "description" => $this->aggregate->getUserListItems()->description,
            "created_at" => $this->aggregate->getUserListItems()->created_at->toDateTimeString(),
            "category" => [
                "id" => $this->aggregate->getUserListItems()->category->id,
                "name" => $this->aggregate->getUserListItems()->category->name,
            ],
            "items" => []
        ];

        foreach ($this->aggregate->getUserListItems()->userListsItems as $userLitsItem) {
            array_push($response["items"], [
                "header" => $userLitsItem->header,
                "description" => $userLitsItem->description,
            ]);
        }

        $this->fill = $response;
        return $this;
    }

    function getResponse(): array
    {
        return $this->fill;
    }


}
