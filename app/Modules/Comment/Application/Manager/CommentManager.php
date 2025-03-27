<?

namespace App\Modules\Comment\Application\Manager;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use Exception;
use Psr\Log\LoggerInterface;

class CommentManager
{
    public function __construct(
        private LoggerInterface     $logger
    ) {}

}
