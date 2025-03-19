<?

namespace App\Modules\Shared\Responses\General\UserLists;

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
        $response = [
            "header" => $entity->header,
            "description" => $entity->description,
            "created_at" => $entity->created_at->toFormattedDayDateString(),
            "category" => [
                "id" => $entity->category->id,
                "name" => $entity->category->name
            ],
            "items" => []
        ];

        foreach ($entity->userListsItems as $userLitsItem) {
            array_push($response["items"], [
                "header" => $userLitsItem->header,
                "description" => $userLitsItem->description,
            ]);
        }

        $entity->response = $response;
        return $entity;
    }
}
