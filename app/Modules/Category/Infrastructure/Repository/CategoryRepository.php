<?

namespace App\Modules\Category\Infrastructure\Repository;

use App\Models\Category;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class CategoryRepository extends BaseEloquentRepository implements ICategoryRepository
{
    protected $model = Category::class;
}