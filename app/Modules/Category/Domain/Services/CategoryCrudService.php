<?

namespace App\Modules\Category\Domain\Services;

use App\Models\Category;
use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryCrudService
{
    public function __construct(
        private ICategoryRepository $categoryRepo
    ) {}

    /**
     * Returns all category data
     * 
     * @return Collection||null
     */
    public function getAll(): ?Collection
    {
        return $this->categoryRepo->getAll();
    }

    /**
     * Returns category according to given id
     * 
     * @param int $id
     * @return Category||null
     */
    public function getById(int $id): ?Category
    {
        return $this->categoryRepo->getById($id);
    }

    /**
     * Creates a category according to given data
     * 
     * @param CategoryDTO $categoryDTO
     * @return Category||null
     */
    public function create(CategoryDTO $categoryDTO): ?Category
    {
        return $this->categoryRepo->create($categoryDTO->toArray());
    }

    /**
     * Update a category according to given data
     * 
     * @param int $id
     * @param CategoryDTO $categoryDTO
     * @return Category||null
     */
    public function update(int $id, CategoryDTO $categoryDTO): ?Category
    {
        $category = $this->categoryRepo->getById($id);

        if (!$category) {
            return null;
        }
        return $this->categoryRepo->update($category, $categoryDTO->toArray());
    }

    /**
     * Deletes a category according to given id
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category = $this->categoryRepo->getById($id);

        if (!$category) {
            return false;
        }
        return $this->categoryRepo->delete($category);
    }
}
