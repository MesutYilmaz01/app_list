<?

namespace App\Modules\Authority\Domain\Aggregate;

use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class UserAuthorityAggregate
{
    private ?UserAuthorityEntity $userAuthorityEntity = null;
    private IBaseResponse $responseType;

    /**
     * @var UserAuthorityEntity[]
     */
    private array $authorityCollection = [];

    public function getAuthorityCollection(): array
    {
        return $this->authorityCollection;
    }

    public function setAuthorityCollection(array $authorityCollection): void
    {
        $this->authorityCollection = $authorityCollection;
    }

    public function setUserAuthorityEntity(UserAuthorityEntity $userAuthorityEntity)
    {
        $this->userAuthorityEntity = $userAuthorityEntity;
    }

    public function getUserAuthorityEntity()
    {
        return $this->userAuthorityEntity;
    }

    public function setResponseType(IBaseResponse $responseType)
    {
        $this->responseType = $responseType;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function getAuthorizedUser()
    {
        return $this->userAuthorityEntity->authorizedUser->toArray();
    }

    public function getOwnerUser()
    {
        return $this->userAuthorityEntity->ownerUser->toArray();
    }

    public function getUserList()
    {
        return $this->userAuthorityEntity->userList->toArray();
    }

    public function getAuthority()
    {
        return $this->userAuthorityEntity->authority->toArray();
    }
}
