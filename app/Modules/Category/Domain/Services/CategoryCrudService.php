<?

namespace App\Modules\Category\Domain\Services;

use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use App\Modules\Category\Infrastructure\Repository\CategoryRepository;

class CategoryCrudService
{
    public ICategoryRepository $categoryRepo;
    
    public function __construct(ICategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    public function getAll()
    {
        return $this->categoryRepo->getAllPaginated();
    }
}