<?

namespace App\Modules\Category\Domain\IRepository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IBaseEloquentRepository 
{
    /**
     * Gets a record according to id
     * 
     
     * @return Collecion||null
     */
    public function getAll($columns = ['*'],  $orderBy = null, $orderType = null): ?Collection;

    /**
     * Get paged items
     *
     * @param integer $paged Items per page
     * @param string $orderBy Column to sort by
     * @param string $sort Sort direction
     * @return Paginator
     */
    public function getAllPaginated($paged = 15, $orderBy = null, $orderType = null): LengthAwarePaginator;

    /**
     * Gets a record according to id
     * 
     * @param int $id
     * @return Model||null
     */
    public function getById(int $id): ?Model;

    /**
     * Create a record according to given array data
     * 
     * @param array $data
     * @return Model||null
     */
    public function create(array $data): ?Model;

    /**
     * Updates a record according to given model and array data
     * 
     * @param Model $model 
     * @param array $data
     * @return Model||null
     */
    public function update(Model $model, array $data): ?Model;
    
    /**
     * Soft deletes a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function delete(Model $model): ?bool;
    
    /**
     * Restores a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function restore(Model $model): ?bool;

    /**
     * Force deletes a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function forceDelete(Model $model): ?bool;
}