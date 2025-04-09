<?

namespace App\Modules\ArtificialIntelligence\Domain\Interfaces;

use Illuminate\Http\JsonResponse;

interface IArtificialIntelligence
{
    public function communicate(array $paramters): JsonResponse;
}
