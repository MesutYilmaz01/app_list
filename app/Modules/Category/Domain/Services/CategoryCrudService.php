<?

namespace App\Modules\Category\Domain\Services;

use App\Modules\Category\Domain\DTO\CategoryDTO;
use App\Modules\Category\Domain\Entities\CategoryEntity;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;

class CategoryCrudService
{
    public function __construct(
        private ICategoryRepository $categoryRepo
    ) {}

    /**
     * Returns all category data
     * 
     * @return array||null
     */
    public function getAll(): ?array
    {
        return $this->categoryRepo->getAll()->all();
    }

    /**
     * Returns popular category data
     * 
     * @param int $count
     * @return array||null
     */
    public function getPopulars(int $count): ?array
    {
        return $this->categoryRepo->getAllWithCount($count);
    }
    
    /**
     * Returns category according to given id
     * 
     * @param int $id
     * @return CategoryEntity||null
     */
    public function getById(int $id): ?CategoryEntity
    {
        return $this->categoryRepo->getById($id);
    }

    /**
     * Creates a category according to given data
     * 
     * @param CategoryDTO $categoryDTO
     * @return CategoryEntity||null
     */
    public function create(CategoryDTO $categoryDTO): ?CategoryEntity
    {
        return $this->categoryRepo->create($categoryDTO->toArray());
    }

    /**
     * Update a category according to given data
     * 
     * @param int $id
     * @param CategoryDTO $categoryDTO
     * @return CategoryEntity||null
     */
    public function update(int $id, CategoryDTO $categoryDTO): ?CategoryEntity
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
