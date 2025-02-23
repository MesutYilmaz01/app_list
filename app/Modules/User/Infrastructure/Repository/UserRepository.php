<?

namespace App\Modules\User\Infrastructure\Repository;

use App\Models\User;
use App\Modules\User\Domain\IRepository\IUserRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserRepository extends BaseEloquentRepository implements IUserRepository
{
    protected $model = User::class;
}