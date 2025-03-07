<?

namespace App\Modules\Shared\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class QueryFilter
{
    protected array $filters;
    protected Builder $builder;

    /**
     * Applies all filter variables to query.
     * 
     * @param Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->getFilters() as $key => $value) {
            $method = "filterBy" . Str::studly($key);
            
            if (!method_exists($this, $method)) {
                continue;
            }

            if (strlen($value)) {
                $this->$method($value);
                continue;
            }

            $this->$method();
        }

        $this->mandatoryFilters();
        return $this->builder;
    }

    /**
     * Get filters 
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * Set filters by given array
     * 
     * @return void
     */
    public function setFilters(array $filters = []): void
    {
        $this->filters = $filters;
    }

    /**
     * Add default filters if there are any.
     * 
     * @return Builder||null
     */
    protected function mandatoryFilters(): ?Builder
    {
        return null;
    }
}
