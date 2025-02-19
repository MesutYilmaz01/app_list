<?

namespace App\Modules\Category\Application\Manager;

use App\Modules\Category\Domain\Services\CategoryCrudService;

class CategoryManager
{
    private CategoryCrudService $categoryCrudService;

    public function __construct(CategoryCrudService $categoryCrudService)
    {
        $this->categoryCrudService = $categoryCrudService;
    }

    public function getAll()
    {
        return $this->categoryCrudService->getAll();
    }
}
