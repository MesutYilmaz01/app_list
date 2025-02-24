<?

namespace App\Modules\UserListItem\Domain\DTO;

use App\Modules\UserListItem\Domain\Enums\StatusType;
use Illuminate\Http\Request;

class UserListItemDTO
{
    private int $user_list_id;
    private string $header;
    private string $description;
    private int $status;

    public function setUserListId(int $userListId) 
    {
        $this->user_list_id = $userListId;
    }

    public function getUserListId()
    {
        return $this->user_list_id;
    }

    public function setHeader(string $header) 
    {
        $this->header = $header;
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function setDescription(string $description) 
    {
        $this->description = $description;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setStatus(int $status) 
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function fromRequest(Request $request, int $userListId)
    {
        $userListItemDTO = new self();

        $userListItemDTO->setUserListId($userListId);
        $userListItemDTO->setHeader($request->header);
        $userListItemDTO->setDescription($request->description);
        $userListItemDTO->setStatus($request->status ?? StatusType::ACTIVE->value);

        return $userListItemDTO;
    }

    public static function forMultiplefromRequest(Request $request, int $userListId)
    {
        $userListItemDTOs = [];

        foreach($request->user_list_items as $userListItem) {
            
            $userListItemDTO = new self();
            $userListItemDTO->setUserListId($userListId);
            $userListItemDTO->setHeader($userListItem["header"]);
            $userListItemDTO->setDescription($userListItem["description"]);
            $userListItemDTO->setStatus($userListItem["status"] ?? StatusType::ACTIVE->value);
            
            array_push($userListItemDTOs, $userListItemDTO);
        }

        return $userListItemDTOs;
    }

    /**
     * Return attributes as an array.
     * 
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}