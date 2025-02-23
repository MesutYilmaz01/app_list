<?

namespace App\Modules\Category\Domain\Services;

use App\Models\Category;
use App\Modules\Category\Domain\IRepository\ICategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryCrudService
{
    public ICategoryRepository $categoryRepo;
    
    public function __construct(ICategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

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
     * @param array $data
     * @return Category||null
     */
    public function create(array $data): ?Category
    {
        return $this->categoryRepo->create($data);
    }

    /**
     * Update a category according to given data
     * 
     * @param int $id
     * @param array $data
     * @return Category||null
     */
    public function update(int $id, array $data): ?Category
    {
        $category = $this->categoryRepo->getById($id);

        if(!$category)
        {
            return null;
        }
        return $this->categoryRepo->update($category, $data);
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
        
        if(!$category)
        {
            return false;
        }
        return $this->categoryRepo->delete($category);
    }
}