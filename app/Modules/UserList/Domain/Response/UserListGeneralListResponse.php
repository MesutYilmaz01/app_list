<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListGeneralListResponse implements IBaseResponse
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
        $response = [];
        foreach ($this->userListAggregate->getUserListList() as $userList) {
            $tempItem = [
                "header" => $userList->header,
                "description" => $userList->description,
                "created_at" => $userList->created_at->toDateTimeString(),
                "category" => [
                    "id" => $userList->category->id,
                    "name" => $userList->category->name,
                ],
                "items" => [],
                "comments" => [],
            ];

            foreach ($userList->userListsItems as $userListItem) {
                array_push($tempItem["items"], [
                    "header" => $userListItem->header,
                    "description" => $userListItem->description,
                ]);
            }

            foreach ($userList->comments as $comment) {
                array_push($tempItem["comments"], [
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

            array_push($response, $tempItem);
        }

        return $response;
    }
}
