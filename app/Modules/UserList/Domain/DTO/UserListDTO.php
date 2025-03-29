<?

namespace App\Modules\UserList\Domain\DTO;

use App\Modules\UserList\Domain\Enums\ShareType;
use App\Modules\UserList\Domain\Enums\StatusType;

class UserListDTO
{
    private string $category_id;
    private string $user_id;
    private string $header;
    private string $description;
    private int $status;
    private int $is_public;

    public function setCategoryId(int $categoryId) 
    {
        $this->category_id = $categoryId;
    }

    public function getCategoryId()
    {
        return $this->category_id;
    }

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
        $this->is_public = $isPublic;
    }

    public function getIsPublic()
    {
        return $this->is_public;
    }

    public static function fromCreateRequest(array $request)
    {
        $userListDTO = new self();

        $userListDTO->setCategoryId($request["category_id"]);
        $userListDTO->setUserId(auth()->user()->id);
        $userListDTO->setHeader($request["header"]);
        $userListDTO->setDescription($request["description"]);
        $userListDTO->setStatus($request["status"] ?? StatusType::ACTIVE->value);
        $userListDTO->setIsPublic($request["is_public"] ?? ShareType::PUBLIC->value);

        return $userListDTO;
    }

    public static function fromUpdateRequest(array $request)
    {
        $userListDTO = new self();

        if(isset($request["category_id"]))
            $userListDTO->setCategoryId($request["category_id"]);
        if(isset($request["header"]))
            $userListDTO->setHeader($request["header"]);
        if(isset($request["description"]))
            $userListDTO->setDescription($request["description"]);
        if(isset($request["status"]))
            $userListDTO->setStatus($request["status"]);
        if(isset($request["is_public"]))
            $userListDTO->setIsPublic($request["is_public"]);

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