<?

namespace App\Modules\User\Domain\Services;

use App\Models\User;
use App\Modules\User\Domain\DTO\UserDTO;
use App\Modules\User\Domain\IRepository\IUserRepository;

class AuthService
{
    public IUserRepository $userRepo;

    public function __construct(IUserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Creates a new user
     * 
     * @param UserDTO $userDTO
     * @return User||null
     */
    public function register(UserDTO $userDTO): ?User
    {
        return $this->userRepo->create([
            "name" => $userDTO->getName(),
            "surname" => $userDTO->getSurname(),
            "email" => $userDTO->getEmail(),
            "username" => $userDTO->getUsername(),
            "password" => $userDTO->getPassword(),
            "user_type" => $userDTO->getUserType()
        ]);
    }

    /**
     * Gets user according to mail
     * 
     * @param string $email
     * @return User||null
     * 
     */
    public function getByEmail(string $email): ?User 
    {
        return $this->userRepo->findByAttributes(['email' => $email]);
    }
}
