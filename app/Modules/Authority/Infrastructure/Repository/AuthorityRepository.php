<?

namespace App\Modules\Authority\Infrastructure\Repository;

use App\Modules\Authority\Domain\Entities\AuthorityEntity;
use App\Modules\Authority\Domain\IRepository\IAuthorityRepository;
use App\Modules\Shared\Repository\BaseEloquentRepository;

class AuthorityRepository extends BaseEloquentRepository implements IAuthorityRepository
{
    protected $model = AuthorityEntity::class;
}
