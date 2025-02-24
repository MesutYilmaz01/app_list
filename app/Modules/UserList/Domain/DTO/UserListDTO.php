<?

namespace App\Modules\UserList\Domain\DTO;

use App\Http\Requests\UserList\UserListCreateRequest;
use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListDTO
{
    private string $user_id;
    private string $header;
    private string $description;
    private string $status;
    private string $isPublic;

    public function setUserId(int $userId) 
    {
        $this->user_id = $userId;
    }

    public function getUserId()
    {
        return $this->user_id;
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

    public function setIsPublic(int $isPublic) 
    {
        $this->isPublic = $isPublic;
    }

    public function getIsPublic()
    {
        return $this->isPublic;
    }

    public static function fromCreateRequest(UserListCreateRequest $request)
    {
        $userListDTO = new self();

        $userListDTO->setUserId(auth()->user()->id);
        $userListDTO->setHeader($request->header);
        $userListDTO->setDescription($request->description);
        $userListDTO->setStatus($request->status ?? StatusType::ACTIVE->value);
        $userListDTO->setIsPublic($request->is_public ?? ShareType::PUBLIC->value);

        return $userListDTO;
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