<?

namespace App\Modules\Category\Application\Manager;

use App\Models\Category;
use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\Services\CategoryCrudService;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class CategoryManager
{
    public function __construct(
        private CategoryCrudService $categoryCrudService
    ) {}

    /**
     * Returns all category data
     * 
     * @return Collection||null
     * 
     * @throws Exception
     */
    public function getAll(): ?Collection
    {
        try {
            $categories = $this->categoryCrudService->getAll();
            Log::info("Categories are listed.");
            return $categories;
        } catch (Exception $e) {
            Log::alert("Categories could not listed.", ["message" => $e->getMessage(), $e->getCode()]);
            throw $e;
        }
    }

    /**
     * Returns category according to given id
     * 
     * @param int $id
     * @return Category||null
     * 
     * @throws Exception
     */
    public function getById(int $id): ?Category
    {
        $category = $this->categoryCrudService->getById($id);

        if (!$category) {

            Log::alert("Category {$id} could not listed.");
            throw new Exception("Category could not found.", 404);
        }

        Log::info("Category {$id} is listed.");
        return $category;
    }

    /**
     * Creates a category according to given data
     * 
     * @param CategoryDTO $categoryDTO
     * @return Category||null
     * 
     * @throws Exception
     */
    public function create(CategoryDTO $categoryDTO): ?Category
    {
        $category = $this->categoryCrudService->create($categoryDTO);

        if (!$category) {
            Log::alert("Category could not created.");
            throw new Exception("Category could not created.", 400);
        }

        Log::info("Category {$category->id} is created.");
        return $category;
    }

    /**
     * Update a category according to given data
     * 
     * @param int $id
     * @param CategoryDTO $categoryDTO
     * @return Category||null
     * 
     * @throws Exception
     */
    public function update(int $id, CategoryDTO $categoryDTO): ?Category
    {
        $category = $this->categoryCrudService->update($id, $categoryDTO);

        if (!$category) {
            Log::alert("Category {$id} could not updated.");
            throw new Exception("Category could not updated.", 400);
        }

        Log::info("Category {$id} is updated.");
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
            Log::alert("Category {$id} could not deleted.");
            throw new Exception("Category could not deleted.", 400);
        }

        Log::info("Category {$id} is deleted.");
        return $isDeleted;
    }
}
