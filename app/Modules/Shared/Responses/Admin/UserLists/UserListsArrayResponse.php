<?

namespace App\Modules\Shared\Responses\Admin\UserLists;

use App\Modules\Shared\Responses\Interface\IArrayResponse;

class UserListsArrayResponse implements IArrayResponse
{
    /**
     * Takes a array and add it response.
     * 
     * @param array $array
     * @return array 
     */
    public function fill(array $array): array
    {
        $response = [];
        foreach ($array as $userList) {
            array_push($response, [
                "id" => $userList["id"],
                "header" => $userList["header"],
                "description" => $userList["description"],
                "status" => $userList["status"],
                "is_public" => $userList["is_public"],
                "created_at" => $userList["created_at"],
                "deleted_at" => $userList["deleted_at"],
                "updated_at" => $userList["updated_at"],
            ]);
        }

        return $response;
    }
}
