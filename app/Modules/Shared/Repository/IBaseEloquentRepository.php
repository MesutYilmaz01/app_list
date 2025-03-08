<?

namespace App\Modules\Shared\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface IBaseEloquentRepository 
{
    /**
     * Parses given array for builder to shape it.
     * 
     * @return BaseEloquentRepository
     */
    public function parseRequest(array $requestArray): BaseEloquentRepository;

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
     * Gets a record according to attributes
     * 
     * @param array $attributes
     * @return Model||null
     */
    public function findByAttributes(array $attributes): ?Model;

    /**
     * Gets a data set according to attributes
     * 
     * @param array $attributes
     * @return Collection||null
     */
    public function getAllByAttributes(array $attributes): ?Collection;

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
     * Soft deletes records according to given conditions
     * 
     * @param Model $model
     * @return bool||null
     */
    public function deleteMany(array $attributes): ?bool;
    
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

    /**
     * Adds given filter to query. Like 'category_id' -> 1, 'user_id' -> 2
     * 
     * @param array $filterAttributes
     * @return BaseEloquentRepository
     */
    public function withFilters(array $filterAttributes): BaseEloquentRepository;

        /**
     * Adds given relationships to query. To use this function, you must add relationships array to related repository and full it with relations.
     * 
     * @param string|array $relationships
     * @return BaseEloquentRepository
     */
    public function with(array|string $relationships): BaseEloquentRepository;
}