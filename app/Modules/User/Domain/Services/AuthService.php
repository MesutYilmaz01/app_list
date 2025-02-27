<?

namespace App\Modules\User\Domain\Services;

use App\Modules\User\Domain\DTO\UserDTO;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\User\Domain\IRepository\IUserRepository;

class AuthService
{
    public function __construct(
        private IUserRepository $userRepo
    ) {}

    /**
     * Creates a new user
     * 
     * @param UserDTO $userDTO
     * @return UserEntity||null
     */
    public function register(UserDTO $userDTO): ?UserEntity
    {
        return $this->userRepo->create($userDTO->toArray());
    }

    /**
     * Gets user according to mail
     * 
     * @param string $email
     * @return UserEntity||null
     * 
     */
    public function getByEmail(string $email): ?UserEntity
    {
        return $this->userRepo->findByAttributes(['email' => $email]);
    }
}
