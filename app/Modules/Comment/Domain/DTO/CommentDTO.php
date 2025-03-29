<?

namespace App\Modules\Comment\Domain\DTO;

use App\Modules\Comment\Domain\Enums\StatusType;

class CommentDTO
{
    private string $user_id;
    private string $user_list_id;
    private string $parent_comment_id;
    private string $comment;
    private int $status;

    public function setUserId(int $userId) 
    {
        $this->user_id = $userId;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setParentCommentId(int $parentCommentId) 
    {
        $this->parent_comment_id = $parentCommentId;
    }

    public function getParentCommentId()
    {
        return $this->parent_comment_id;
    }

    public function setUserListId(int $userListId) 
    {
        $this->user_list_id = $userListId;
    }

    public function getUserListId()
    {
        return $this->user_list_id;
    }

    public function setComment(string $comment) 
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setStatus(int $status) 
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function fromCreateRequest(array $request)
    {
        $commentDTO = new self();

        $commentDTO->setUserId(auth()->user()->id);
        if(isset($request["parent_comment_id"]))
            $commentDTO->setParentCommentId($request["parent_comment_id"]);
        $commentDTO->setUserListId($request["user_list_id"]);
        $commentDTO->setComment($request["comment"]);
        $commentDTO->setStatus(StatusType::PASSIVE->value);

        return $commentDTO;
    }

    public static function fromUpdateRequest(array $request)
    {
        $commentDTO = new self();

        if(isset($request["user_id"]))
            $commentDTO->setUserId($request["user_id"]);
        if(isset($request["parent_comment_id"]))
            $commentDTO->setParentCommentId($request["parent_comment_id"]);
        if(isset($request["user_list_id"]))
            $commentDTO->setUserListId($request["user_list_id"]);
        if(isset($request["comment"]))
            $commentDTO->setComment($request["comment"]);
        if(isset($request["status"]))
            $commentDTO->setStatus($request["status"]);

        return $commentDTO;
    }

    /**
     * Return attributes as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}