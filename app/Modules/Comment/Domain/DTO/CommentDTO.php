<?

namespace App\Modules\Comment\Domain\DTO;

use App\Modules\Comment\Domain\Enums\StatusType;

class CommentDTO
{
    private string $userId;
    private string $userListId;
    private string $parentCommentId;
    private string $comment;
    private int $status;

    public function setUserId(int $userId) 
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setParentCommentId(int $parentCommentId) 
    {
        $this->parentCommentId = $parentCommentId;
    }

    public function getParentCommentId()
    {
        return $this->parentCommentId;
    }

    public function setUserListId(int $userListId) 
    {
        $this->userListId = $userListId;
    }

    public function getUserListId()
    {
        return $this->userListId;
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