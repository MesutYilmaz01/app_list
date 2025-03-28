<?

namespace App\Modules\Comment\Domain\Aggregate;

use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class CommentAggregate
{
    private ?CommentEntity $commentEntity = null;
    private IBaseResponse $responseType;

    public function setCommentEntity(CommentEntity $commentEntity)
    {
        $this->commentEntity = $commentEntity;
    }

    public function getCommentEntity()
    {
        return $this->commentEntity;
    }

    public function setResponseType(IBaseResponse $responseType)
    {
        $this->responseType = $responseType;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function getUserList()
    {
        return $this->commentEntity->userList->toArray();
    }

    public function getOwner()
    {
        return $this->commentEntity->user->toArray();
    }

    public function getParent()
    {
        return $this->commentEntity->parent->toArray();
    }
}
