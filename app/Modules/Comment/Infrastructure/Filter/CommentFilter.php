<?

namespace App\Modules\Comment\Infrastructure\Filter;

use App\Modules\Shared\Filter\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class CommentFilter extends QueryFilter
{
    /**
     * All of this filter MUST start with filterBy prefix and continue according to request style 
     * For example
     * Request have category_id then you use should a function name like => filterByCategoryId
     */


    /**
     * Filters according to id
     * 
     * @param int $id
     * @return Builder
     */
    public function filterById(int $id): Builder
    {
        return $this->builder->where('id', '=', $id);
    }

    /**
     * Filters according to user id
     * 
     * @param int $userId
     * @return Builder
     */
    public function filterByCategoryId(int $userId): Builder
    {
        return $this->builder->where('user_id', '=', $userId);
    }

    /**
     * Filters equal date by created date according to given date
     * 
     * @param int string $date
     * @return Builder
     */
    public function filterByDate(string $date): Builder
    {
        return $this->builder->whereDate('created_at', $date);
    }

    /**
     * Filters before date by created date according to given date
     * 
     * @param int string $date
     * @return Builder
     */
    public function filterByBeforeDate(string $date): Builder
    {
        return $this->builder->whereDate('created_at', '<=', $date);
    }

    /**
     * Filters after date by created date according to given date
     * 
     * @param int string $date
     * @return Builder
     */
    public function filterByAfterDate(string $date): Builder
    {
        return $this->builder->whereDate('created_at', '>=', $date);
    }
}
