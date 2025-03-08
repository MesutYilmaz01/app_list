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
     * Filter which is going to use. That is gibven by each repository
     */
    protected $filter;

    /**
     * Relationships which is given each repository individually. For example userrepository may have $relationships = ['user_lists','messages']
     */
    protected array $relationships = [];

    /**
     * Array of relationships to include in next query if its assigned anywhere.
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
     * Get the model from the IoC container and get the filter.
     * @throws BindingResolutionException
     */
    public function __construct()
    {
        $this->model = app()->make($this->model);
        $this->filter = app($this->filter);
    }

    /**
     * Declare given attributes to realted variables like order and paginaiton.
     * 
     * @return BaseEloquentRepository
     */
    public function parseRequest(array $requestArray): BaseEloquentRepository
    {
        $this->setOrder($requestArray);

        $this->setPagination($requestArray);

        return $this;
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
     * Gets a data set according to attributes
     * 
     * @param array $attributes
     * @return Collection||null
     */
    public function getAllByAttributes(array $attributes): ?Collection
    {
        return $this->model->where($attributes)->get();
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
     * Soft deletes records according to given conditions
     * 
     * @param Model $model
     * @return bool||null
     */
    public function deleteMany(array $attributes): ?bool
    {
        return $this->model->where($attributes)->delete();
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
     * Adds given filter to query. Like 'category_id' -> 1, 'user_id' -> 2
     * 
     * @param array $filterAttributes
     * @return BaseEloquentRepository
     */
    public function withFilters(array $filterAttributes): BaseEloquentRepository
    {
        $this->filter->setFilters($filterAttributes);
        $this->model = $this->model->filter($this->filter);
        return $this;
    }

    /**
     * Adds given relationships to query. To use this function, you must add relationships array to related repository and full it with relations.
     * 
     * @param string||array $relationships
     * @return BaseEloquentRepository
     */
    public function with(array|string $relationships): BaseEloquentRepository
    {
        $this->requiredRelationships = [];

        if ($relationships == 'all') {
            $this->requiredRelationships = $this->relationships;
        } elseif (is_array($relationships)) {
            $this->requiredRelationships = array_filter($relationships, function ($value) {
                return in_array($value, $this->relationships);
            });
        } elseif (is_string($relationships)) {
            array_push($this->requiredRelationships, $relationships);
        }

        return $this;
    }

    /**
     * Sets order by and order type if they are exist.
     * 
     * @param array $requestArray
     * @return void
     */
    private function setOrder(array $requestArray): void
    {
        if (isset($requestArray["order_by"])) {
            $this->orderBy = $requestArray["order_by"];
        }

        if (isset($requestArray["order_type"])) {
            $this->orderType = $requestArray["order_type"];
        }
    }

    /**
     * Sets pagination and per page if they are exist.
     * 
     * @param array $requestArray
     * @return void
     */
    private function setPagination(array $requestArray): void
    {
        if (isset($requestArray["with_pagination"]) && boolval($requestArray["with_pagination"])) {
            $this->withPagination = true;
        }

        if (isset($requestArray["per_page"]) && is_numeric($requestArray["per_page"])) {
            $this->perPage = (int)$requestArray["per_page"];
        }
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
