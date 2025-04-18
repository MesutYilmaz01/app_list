<?

namespace App\Modules\Follow\Domain\DTO;

class FollowDTO
{
    private int $user_id;
    private int $followed_user_id;

    public function setUserId(string $user_id)
    {
        $this->user_id = $user_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setFollowedUserId(string $follow_user_id)
    {
        $this->followed_user_id = $follow_user_id;
    }

    public function getFollowedUserId()
    {
        return $this->followed_user_id;
    }

    public static function fromCreateRequest(array $request)
    {
        $followDTO = new self();

        $followDTO->setUserId(auth()->user()->id);
        $followDTO->setFollowedUserId($request["followed_user_id"]);

        return $followDTO;
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
