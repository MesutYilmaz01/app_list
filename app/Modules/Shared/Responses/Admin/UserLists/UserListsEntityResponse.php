<?

namespace App\Modules\Shared\Responses\Admin\UserLists;

use App\Modules\Shared\Interfaces\Entities\IEntity;
use App\Modules\Shared\Responses\Interface\IEntityResponse;

class UserListsEntityResponse implements IEntityResponse
{
    /**
     * Takes a IEntity and add it response.
     * 
     * @param IEntity $entity
     * @return IEntity 
     */
    public function fill(IEntity $entity): IEntity
    {
        $response = $entity->toArray();
        unset($response["category_id"]);
        unset($response["user_id"]);
        $response["items"] = $response["user_lists_items"];
        unset($response["user_lists_items"]);
        $response["category"] = [
            "id" => $response["category"]["id"],
            "name" => $response["category"]["name"],
        ];

        $entity->response = $response;
        return $entity;
    }
}