<?

namespace App\Modules\Shared\Responses\Interface;

interface IBaseResponse
{
    /**
     * Fills a response class according to class type.
     * 
     */
    public function fill(): array;
}