<?

namespace App\Modules\Category\Application\Manager;

use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Category\Domain\Services\CategoryCrudService;
use Exception;
use Psr\Log\LoggerInterface;

class CategoryManager
{
    public function __construct(
        private CategoryCrudService $categoryCrudService,
        private LoggerInterface $logger
    ) {}

    /**
     * Returns all category data
     * 
     * @return array||null
     * 
     * @throws Exception
     */
    public function getAll(): ?array
    {
        $categories = $this->categoryCrudService->getAll();
        
        if (!$categories) {
            $this->logger->alert("Categories could not listed.");
            throw new Exception("Categories are not listed.", 404);
        }

        $this->logger->info("Categories are listed.");
        return $categories;
    }

    /**
     * Returns CategoryEntity according to given id
     * 
     * @param int $id
     * @return CategoryEntity||null
     * 
     * @throws Exception
     */
    public function getById(int $id): ?CategoryEntity
    {
        $category = $this->categoryCrudService->getById($id);

        if (!$category) {

            $this->logger->alert("Category {$id} could not listed.");
            throw new Exception("Category could not found.", 404);
        }

        $this->logger->info("Category {$id} is listed.");
        return $category;
    }

    /**
     * Creates a category according to given data
     * 
     * @param CategoryDTO $categoryDTO
     * @return CategoryEntity||null
     * 
     * @throws Exception
     */
    public function create(CategoryDTO $categoryDTO): ?CategoryEntity
    {
        $category = $this->categoryCrudService->create($categoryDTO);

        if (!$category) {
            $this->logger->alert("Category could not created.");
            throw new Exception("Category could not created.", 400);
        }

        $this->logger->info("Category {$category->id} is created.");
        return $category;
    }

    /**
     * Update a category according to given data
     * 
     * @param int $id
     * @param CategoryDTO $categoryDTO
     * @return CategoryEntity||null
     * 
     * @throws Exception
     */
    public function update(int $id, CategoryDTO $categoryDTO): ?CategoryEntity
    {
        $category = $this->categoryCrudService->update($id, $categoryDTO);

        if (!$category) {
            $this->logger->alert("Category {$id} could not updated.");
            throw new Exception("Category could not updated.", 400);
        }

        $this->logger->info("Category {$id} is updated.");
        return $category;
    }

    /**
     * Deletes a category according to given id
     * 
     * @param int $id
     * @return bool
     * 
     * @throws Exception
     */
    public function delete(int $id): bool
    {
        $isDeleted = $this->categoryCrudService->delete($id);

        if (!$isDeleted) {
            $this->logger->alert("Category {$id} could not deleted.");
            throw new Exception("Category could not deleted.", 400);
        }

        $this->logger->info("Category {$id} is deleted.");
        return $isDeleted;
    }
}
