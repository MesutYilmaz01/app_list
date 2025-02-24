<?

namespace App\Modules\UserListItem\Infrastructure\Repository;

use App\Models\UserListItem;
use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserListItemRepository extends BaseEloquentRepository implements IUserListItemRepository
{
    protected $model = UserListItem::class;
}