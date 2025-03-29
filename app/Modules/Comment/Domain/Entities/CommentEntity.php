<?

namespace App\Modules\Comment\Domain\Entities;

use App\Models\Comment;
use App\Modules\Shared\Interfaces\Entities\IEntity;
use App\Modules\Shared\Traits\Filterable;
use App\Modules\Comment\Domain\Enums\StatusType;

class CommentEntity extends Comment implements IEntity
{
    use Filterable;

    public function isApproved()
    {
        return $this->status == StatusType::ACTIVE->value;
    }
}
