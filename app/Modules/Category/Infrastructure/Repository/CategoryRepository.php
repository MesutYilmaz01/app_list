<?

namespace App\Modules\Category\Infrastructure\Repository;

use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class CategoryRepository extends BaseEloquentRepository implements ICategoryRepository
{
    protected $model = CategoryEntity::class;
    protected array $relationships = [
        'userLists'
    ];

    /**
     * Gets categories with user lists count according to id
     * 
     * @param int $count
     * @return array||null
     */
    public function getAllWithCount(int $count): ?array
    {
        return  $this->model->query()
            ->withCount('userLists')
            ->having('user_lists_count', '>', $count)
            ->get()->toArray();
    }
}
