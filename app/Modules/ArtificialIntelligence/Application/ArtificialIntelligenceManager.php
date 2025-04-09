<?

namespace App\Modules\ArtificialIntelligence\Application;

use App\Modules\ArtificialIntelligence\Domain\Interfaces\IArtificialIntelligence;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class ArtificialIntelligenceManager
{
    public function __construct(
        private IArtificialIntelligence $artificialIntelligence,
        private LoggerInterface $logger
    ) {}

    /**
     * Communicates with ai according to given prompt and returns answer as json.
     * 
     * @param array $parameters
     * @return JsonResponse
     */
    public function communicate(array $parameters): JsonResponse
    {
        return $this->artificialIntelligence->communicate($parameters);
    }
}
