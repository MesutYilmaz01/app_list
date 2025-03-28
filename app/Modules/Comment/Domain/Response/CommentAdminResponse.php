<?php

namespace App\Modules\Comment\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\Comment\Domain\Aggregate\CommentAggregate;

class CommentAdminResponse implements IBaseResponse
{
    public function __construct(
        private CommentAggregate $commentAggregate
    ) {}

    /**
     * Fills commentAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [
            "id" => $this->commentAggregate->getCommentEntity()->id,
            "user_id" => $this->commentAggregate->getCommentEntity()->user_id,
            "parent_comment_id" => $this->commentAggregate->getCommentEntity()->parent_comment_id,
            "user_list_id" => $this->commentAggregate->getCommentEntity()->user_list_id,
            "comment" => $this->commentAggregate->getCommentEntity()->comment,
            "status" => $this->commentAggregate->getCommentEntity()->status,
            "approved_at" => $this->commentAggregate->getCommentEntity()->approved_at ? $$this->commentAggregate->getCommentEntity()->approved_at->toDateTimeString() : null,
            "created_at" => $this->commentAggregate->getCommentEntity()->created_at->toDateTimeString(),
            "updated_at" => $this->commentAggregate->getCommentEntity()->updated_at->toDateTimeString(),
            "deleted_at" => $this->commentAggregate->getCommentEntity()->deleted_at ? $$this->commentAggregate->getCommentEntity()->deleted_at->toDateTimeString() : null,
        ];

        return $response;
    }
}
