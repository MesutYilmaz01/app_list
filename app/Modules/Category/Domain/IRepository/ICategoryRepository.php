<?

namespace App\Modules\Category\Domain\IRepository;

use App\Modules\Shared\Repository\IBaseEloquentRepository;

interface ICategoryRepository extends IBaseEloquentRepository
{
    /**
     * Gets categories with user lists count according to id
     * 
     * @param int $count
     * @return array||null
     */
    public function getAllWithCount(int $count): ?array;
}