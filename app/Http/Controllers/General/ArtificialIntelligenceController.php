<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\ArtificialIntelligence\ArtificialIntelligenceShowRequest;
use App\Modules\ArtificialIntelligence\Application\ArtificialIntelligenceManager;
use Illuminate\Http\JsonResponse;

class ArtificialIntelligenceController extends Controller
{
    public function __construct(
        private ArtificialIntelligenceManager $artificialIntelligenceManager
    ) {}

    /**
     * Communicates with ai according to given prompt and returns answer as json.
     * 
     * @param ArtificialIntelligenceShowRequest $request
     * @return JsonResponse
     */
    public function communicate(ArtificialIntelligenceShowRequest $request): JsonResponse
    {
        return $this->artificialIntelligenceManager->communicate($request->validated());
    }
}
