<?

namespace App\Modules\UserListItem\Infrastructure\Repository;

use App\Modules\UserListItem\Domain\IRepository\IUserListItemRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;
use App\Modules\UserListItem\Domain\Entities\UserListsItemEntity;

class UserListItemRepository extends BaseEloquentRepository implements IUserListItemRepository
{
    protected $model = UserListsItemEntity::class;
}