<?

namespace App\Modules\Authority\Domain\Aggregate;

use App\Modules\Authority\Domain\Entities\AuthorityEntity;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class AuthorityAggregate
{
    private ?AuthorityEntity $authorityEntity = null;
    private IBaseResponse $responseType;
    private array $authorityList = [];

    public function setAuthorityEntity(AuthorityEntity $authorityEntity)
    {
        $this->authorityEntity = $authorityEntity;
    }

    public function getAuthorityEntity()
    {
        return $this->authorityEntity;
    }

    public function setAuthorityList(array $authorityList)
    {
        $this->authorityList = $authorityList;
    }

    public function getAuthorityList()
    {
        return $this->authorityList;
    }

    public function setResponseType(IBaseResponse $responseType)
    {
        $this->responseType = $responseType;
    }

    public function getResponseType()
    {
        return $this->responseType;
    }
}
