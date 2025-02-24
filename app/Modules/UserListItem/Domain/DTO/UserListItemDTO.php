<?

namespace App\Modules\UserListItem\Domain\DTO;

use App\Modules\UserListItem\Domain\Enums\StatusType;
use Illuminate\Http\Request;

class UserListItemDTO
{
    private string $header;
    private string $description;
    private string $status;

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

    public static function fromRequest(Request $request)
    {
        $userListItemDTO = new self();

        $userListItemDTO->setHeader($request->header);
        $userListItemDTO->setDescription($request->description);
        $userListItemDTO->setStatus($request->status ?? StatusType::ACTIVE->value);

        return $userListItemDTO;
    }
    
    public static function forMultiplefromRequest(Request $request)
    {
        $userListItemDTOs = [];

        foreach($request->user_list_items as $userListItem) {

            $userListItemDTO = new self();
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