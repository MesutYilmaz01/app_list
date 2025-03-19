<?

namespace App\Modules\Shared\Responses\Interface;

use App\Modules\Shared\Interfaces\Entities\IEntity;

interface IEntityResponse
{
    /**
     * Takes a IEntity and add it response.
     * 
     * @param IEntity $entity
     * @return IEntity 
     */
    public function fill(IEntity $entity): IEntity;
}