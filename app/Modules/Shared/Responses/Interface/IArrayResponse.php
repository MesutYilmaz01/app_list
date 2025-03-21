<?

namespace App\Modules\Shared\Responses\Interface;


interface IArrayResponse
{
    /**
     * Takes a array and add it response.
     * 
     * @param array $data
     * @return array 
     */
    public function fill(array $data): array;
}