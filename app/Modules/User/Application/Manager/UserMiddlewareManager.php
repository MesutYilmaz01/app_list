<?

namespace App\Modules\User\Application\Manager;

use App\Modules\User\Domain\Enums\UserType;

class UserMiddlewareManager
{
    /**
     * This is check if user is admin or not
     * 
     * @return bool
     */
    public function isAdmin(): bool
    {
        if(auth()->user()->user_type == UserType::USER) {
            return false;
        }

        return true;
    }
}
