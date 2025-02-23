<?

namespace App\Modules\Shared\Repository;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BaseEloquentRepository implements IBaseEloquentRepository
{
    /**
     * Model which is going to use. That is given by each repository
     */ 
    protected $model;

    /**
     * Relationships which is going to use when model getting if thhat is given
     */
    protected array $relationShips = [];

    /**
     * Array of relationships to include in next query
     * @var array
     */
    protected array $requiredRelationships = [];

    /**
     * Default orderBy
     */
    private string $orderBy = 'id';
    
    /**
     * Default orderType
     */
    private string $orderType = 'desc';

    /**
     * Default pagination option
     */
    private bool $withPagination = false;

    /**
     * Default pagination count
     */
    private int $perPage = 30;
    
    /**
     * Get the model from the IoC container
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make($this->model);
    }

    /**
     * Gets a record according to id
     * 
     * @return Collecion||null
     */
    public function getAll($columns = ['*'],  $orderBy = null, $orderType = null): ?Collection
    {
        $orderBy = $orderBy ?? $this->orderBy;
        $orderType = $orderType ?? $this->orderType;

        return $this->model
            ->with($this->requiredRelationships)
            ->orderBy($orderBy, $orderType)
            ->get($columns);
    }

    /**
     * Get paged items
     *
     * @param integer $paged Items per page
     * @param string $orderBy Column to sort by
     * @param string $sort Sort direction
     * @return Paginator
     */
    public function getAllPaginated($paged = 15, $orderBy = null, $orderType = null): LengthAwarePaginator
    {
        $orderBy = $orderBy ?? $this->orderBy;
        $orderType = $orderType ?? $this->orderType;

        return $this->model
                ->with($this->requiredRelationships)
                ->orderBy($orderBy, $orderType)
                ->paginate($paged);
    }

    /**
     * Gets a record according to id
     * 
     * @param int $id
     * @return Model||null
     */
    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    /**
     * Gets a record according to attributes
     * 
     * @param array $attributes
     * @return Model||null
     */
    public function findByAttributes(array $attributes): ?Model
    {
        return $this->model->where($attributes)->first();
    }

    /**
     * Create a record according to given array data
     * 
     * @param array $data
     * @return Model||null
     */
    public function create(array $data): ?Model
    {
        return $this->model->create($data);
    }

    /**
     * Updates a record according to given model and array data
     * 
     * @param Model $model 
     * @param array $data
     * @return Model||null
     */
    public function update(Model $model, array $data): ?Model
    {
        $model->fill($data)->save();
        return $model;
    }

    /**
     * Soft deletes a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    /**
     * Restores a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function restore(Model $model): ?bool
    {
        return $model->restore();
    }

    /**
     * Force deletes a record according to given model
     * 
     * @param Model $model
     * @return bool||null
     */
    public function forceDelete(Model $model): ?bool
    {
        return $model->forceDelete();
    }

    /**
     * @throws Throwable
     */
    public function beginTransaction()
    {
        DB::beginTransaction();
    }

    /**
     * @throws Throwable
     */
    public function rollback()
    {
        DB::rollBack();
    }

    /**
     * @throws Throwable
     */
    public function commit()
    {
        DB::commit();
    }
}