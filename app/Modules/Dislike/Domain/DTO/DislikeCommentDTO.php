<?

namespace App\Modules\Dislike\Domain\DTO;

class DislikeCommentDTO
{
    private int $comment_id;
    private int $user_id;

    public function setCommentId(string $comment_id) 
    {
        $this->comment_id = $comment_id;
    }

    public function getCommentId()
    {
        return $this->comment_id;
    }

    public function setUserId(string $user_id) 
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public static function fromCreateRequest(array $request)
    {
        $dislikeCommentDTO = new self();

        $dislikeCommentDTO->setCommentId($request["comment_id"]);
        $dislikeCommentDTO->setUserId(auth()->user()->id);

        return $dislikeCommentDTO;
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