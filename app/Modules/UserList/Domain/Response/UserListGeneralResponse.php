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
                "id" => $this->userListAggregate->getCategory()->id,
                "name" => $this->userListAggregate->getCategory()->name,
            ],
            "items" => [],
            "comments" => [],
        ];

        foreach ($this->userListAggregate->getUserListItems() as $userListItem) {
            array_push($response["items"], [
                "header" => $userListItem->header,
                "description" => $userListItem->description,
            ]);
        }

        foreach ($this->userListAggregate->getComments() as $comment) {
            array_push($response["comments"], [
                "parent_comment_id" => isset($comment->parent_comment_id) ? $comment->parent_comment_id : null,
                "comment" => $comment->comment,
                "created_at" => $comment->created_at->toDateTimeString(),
                "user" => [
                    "name" => $comment->user->name,
                    "surname" => $comment->user->surname,
                    "username" => $comment->user->username,
                ]
            ]);
        }

        return $response;
    }
}
