<?

namespace App\Modules\Authority\Domain\DTO;

class UserAuthorityDTO
{
    private int $owner_user_id;
    private int $authorized_user_id;
    private int $user_list_id;
    private int $authority_id;

    public function setOwnerUserId(int $ownerUserId)
    {
        $this->owner_user_id = $ownerUserId;
    }

    public function getOwnerUserId()
    {
        return $this->owner_user_id;
    }

    public function setAuthorizedUserId(int $authorizedUserId)
    {
        $this->authorized_user_id = $authorizedUserId;
    }

    public function getAuthorizedUserId()
    {
        return $this->authorized_user_id;
    }

    public function setUserListId(int $userListId)
    {
        $this->user_list_id = $userListId;
    }

    public function getUserListId()
    {
        return $this->user_list_id;
    }

    public function setAuthorityId(int $authorityId)
    {
        $this->authority_id = $authorityId;
    }

    public function getAuthorityId()
    {
        return $this->authority_id;
    }

    public static function fromCreateRequest(array $request)
    {
        $userAuthorityDTO = new self();

        $userAuthorityDTO->setOwnerUserId(auth()->user()->id);
        $userAuthorityDTO->setAuthorizedUserId($request["authorized_user_id"]);
        $userAuthorityDTO->setUserListId($request["user_list_id"]);
        $userAuthorityDTO->setAuthorityId($request["authority_id"]);

        return $userAuthorityDTO;
    }

    public static function fromUpdateRequest(array $request)
    {
        $userAuthorityDTO = new self();

        if (isset($request["authority_id"]))
            $userAuthorityDTO->setAuthorityId($request["authority_id"]);

        return $userAuthorityDTO;
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
