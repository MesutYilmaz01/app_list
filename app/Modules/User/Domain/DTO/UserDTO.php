<?

namespace App\Modules\User\Domain\DTO;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Modules\User\Domain\Enums\UserType;
use Illuminate\Support\Facades\Hash;

class UserDTO
{
    private string $username;
    private string $name;
    private string $surname;
    private string $email;
    private string $password;
    private int $userType;

    public function setUsername(string $username) 
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setName(string $name) 
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setSurname(string $surname) 
    {
        $this->surname = $surname;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setEmail(string $email) 
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword(string $password) 
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUserType (int $userType) 
    {
        $this->userType = $userType;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public static function fromCreateRequest(CreateUserRequest $request)
    {
        $userDTO = new self();

        $userDTO->setName($request->name);
        $userDTO->setSurname($request->surname);
        $userDTO->setUsername($request->username);
        $userDTO->setEmail($request->email);
        $userDTO->setPassword(Hash::make($request->password));
        $userDTO->setUserType($request->userType ?? UserType::USER->value);

        return $userDTO;
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