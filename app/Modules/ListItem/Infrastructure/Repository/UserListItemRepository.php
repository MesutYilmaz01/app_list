<?

namespace App\Modules\Category\Infrastructure\Repository;

use App\Models\UserListItem;
use App\Modules\ListItem\Domain\IRepository\IUserListItemRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class UserListItemRepository extends BaseEloquentRepository implements IUserListItemRepository
{
    protected $model = UserListItem::class;
}