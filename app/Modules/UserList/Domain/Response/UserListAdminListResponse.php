<?php

namespace App\Modules\UserList\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\UserList\Domain\Aggregate\UserListAggregate;

class UserListAdminListResponse implements IBaseResponse
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
                "id" => $userList->id,
                "user_id" => $userList->user_id,
                "header" => $userList->header,
                "description" => $userList->description,
                "status" => $userList->status,
                "is_public" => $userList->is_public,
                "created_at" => $userList->created_at->toDateTimeString(),
                "updated_at" => $userList->updated_at->toDateTimeString(),
                "deleted_at" => $userList->deleted_at ? $userList->deleted_at->toDateTimeString() : null,
                "category" => [
                    "id" => $userList->category->id,
                    "name" => $userList->category->name,
                ],
                "items" => [],
                "comments" => [],
            ];

            foreach ($userList->userListsItems as $userListItem) {
                array_push($tempItem["items"], [
                    "id" => $userListItem->id,
                    "header" => $userListItem->header,
                    "description" => $userListItem->description,
                    "status" => $userListItem->status,
                    "created_at" => $userListItem->created_at->toDateTimeString(),
                    "updated_at" => $userListItem->updated_at->toDateTimeString(),
                    "deleted_at" => $userListItem->deleted_at ? $userListItem->deleted_at->toDateTimeString() : null,
                ]);
            }

            foreach ($userList->comments as $comment) {
                array_push($tempItem["comments"], [
                    "id" => $comment->id,
                    "parent_comment_id" => $comment->parent_comment_id ? $comment->parent_comment_id : null,
                    "comment" => $comment->comment,
                    "status" => $comment->status,
                    "approved_at" => $comment->approved_at ? $comment->approved_at->toDateTimeString() : null,
                    "created_at" => $comment->created_at->toDateTimeString(),
                    "updated_at" => $comment->updated_at->toDateTimeString(),
                    "deleted_at" => $comment->deleted_at ? $comment->deleted_at->toDateTimeString() : null,
                    "user" => [
                        "id" => $comment->user->id,
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
