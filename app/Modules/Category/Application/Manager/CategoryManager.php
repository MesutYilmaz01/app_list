<?

namespace App\Modules\Category\Application\Manager;

use App\Modules\Category\Domain\Aggregate\CategoryAggregate;
use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Category\Domain\Services\CategoryCrudService;
use App\Modules\Shared\Responses\Interface\IBaseResponse;
use Exception;
use Psr\Log\LoggerInterface;

class CategoryManager
{
    public function __construct(
        private CategoryCrudService $categoryCrudService,
        private CategoryAggregate $categoryAggregate,
        private LoggerInterface $logger
    ) {}

    /**
     * Returns all category data
     * 
     * @return array||null
     * 
     * @throws Exception
     */
    public function getAll(): array
    {
        $categories = $this->categoryCrudService->getAll();

        if (!count($categories)) {
            $this->logger->alert("Categories could not listed.");
            throw new Exception("Categories are not listed.", 404);
        }

        $this->logger->info("Categories are listed.");

        $this->categoryAggregate->setCategoryList($categories);
        return $this->categoryAggregate->getResponseType()->fill();
    }

    /**
     * Returns popular category data
     * 
     * 
     * @return array||null
     * 
     * @throws Exception
     */
    public function getPopulars(): ?array
    {
        $categories = $this->categoryCrudService->getPopulars(2);

        if (!count($categories)) {
            $this->logger->alert("Categories could not listed.");
            throw new Exception("Categories are not listed.", 404);
        }

        $this->logger->info("Categories are listed.");

        $this->categoryAggregate->setCategoryList($categories);
        return $this->categoryAggregate->getResponseType()->fill();
    }

    /**
     * Returns CategoryEntity according to given id
     * 
     * @param int $id
     * @return array
     * 
     * @throws Exception
     */
    public function getById(int $id): array
    {
        $category = $this->categoryCrudService->getById($id);

        if (!$category) {

            $this->logger->alert("Category {$id} could not listed.");
            throw new Exception("Category could not found.", 404);
        }

        $this->logger->info("Category {$id} is listed.");

        $this->categoryAggregate->setCategoryEntity($category);
        return $this->categoryAggregate->getResponseType()->fill();
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

    /**
     * Sets response type of comment aggregate
     * 
     * @param class-string<IBaseResponse> $responseTypeName
     * @return CategoryManager
     */
    public function setResponseType(string $responseTypeName): CategoryManager
    {
        $this->categoryAggregate->setResponseType(app($responseTypeName));
        return $this;
    }
}
