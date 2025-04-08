<?

namespace App\Modules\Dislike\Domain\DTO;

class DislikeUserListDTO
{
    private int $user_list_id;
    private int $user_id;

    public function setUserListId(string $user_list_id) 
    {
        $this->user_list_id = $user_list_id;
    }

    public function getUserListId()
    {
        return $this->user_list_id;
    }

    public function setUserId(string $user_id) 
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public static function fromCreateRequest(array $request)
    {
        $dislikeUserListDTO = new self();

        $dislikeUserListDTO->setUserListId($request["user_list_id"]);
        $dislikeUserListDTO->setUserId(auth()->user()->id);

        return $dislikeUserListDTO;
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