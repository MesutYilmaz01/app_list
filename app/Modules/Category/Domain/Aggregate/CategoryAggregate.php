<?

namespace App\Modules\Category\Domain\Aggregate;

use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class CategoryAggregate
{
    private ?CategoryEntity $categoryEntity = null;
    private IBaseResponse $responseType;
    private array $categoryList = [];

    public function setCategoryEntity(CategoryEntity $categoryEntity)
    {
        $this->categoryEntity = $categoryEntity;
    }

    public function getCategoryEntity()
    {
        return $this->categoryEntity;
    }

    public function setCategoryList(array $categoryList)
    {
        $this->categoryList = $categoryList;
    }

    public function getCategoryList()
    {
        return $this->categoryList;
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
