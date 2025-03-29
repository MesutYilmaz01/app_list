<?php

namespace App\Modules\Comment\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\Comment\Domain\Aggregate\CommentAggregate;

class CommentUserResponse implements IBaseResponse
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
            "comment" => $this->commentAggregate->getCommentEntity()->comment,
        ];

        return $response;
    }
}
