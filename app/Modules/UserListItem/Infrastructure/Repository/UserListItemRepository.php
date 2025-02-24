<?

namespace App\Modules\UserListItem\Infrastructure\Repository;

use App\Models\UserListsItem;
use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserListItemRepository extends BaseEloquentRepository implements IUserListItemRepository
{
    protected $model = UserListsItem::class;
}