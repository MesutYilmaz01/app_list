<?

namespace App\Modules\User\Application\Manager;

use App\Modules\User\Domain\DTO\UserDTO;
use App\Modules\User\Domain\Entities\UserEntity;
use App\Modules\User\Domain\Services\AuthService;
use Exception;
use Psr\Log\LoggerInterface;

class AuthManager
{
    public function __construct(
        private AuthService $authService,
        private LoggerInterface $logger
    ) {}

    /**
     * Creates a new user
     * 
     * @param UserDTO $userDTO
     * @return UserEntity||null
     * 
     * @throws Exception
     */
    public function register(UserDTO $userDTO): ?UserEntity
    {
        $user = $this->authService->register($userDTO);

        if (!$user) {
            $this->logger->alert("User could not created.");
            throw new Exception("User could not created.", 400);
        }

        $this->logger->info("User {$user->id} is created.");
        return $user;
    }

    /**
     * Gets a user according to mail
     * 
     * @param string $email
     * @return UserEntity||null
     * 
     * @throws Exception
     */
    public function getByEmail(string $email): ?UserEntity
    {
        $user = $this->authService->getByEmail($email);

        if (!$user) {
            $this->logger->alert("User could not find with this email.");
            throw new Exception("User could not find with this email.", 400);
        }

        $this->logger->info("User {$user->id} is finded.");
        return $user;
    }
}
