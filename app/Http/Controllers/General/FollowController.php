<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Follow\FollowRequest;
use App\Modules\Follow\Application\Manager\FollowManager;
use App\Modules\Follow\Domain\DTO\FollowDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FollowController extends Controller
{
    public function __construct(
        private FollowManager $followManager,
    ) {}

    /**
     * Folllow or reverse follow.
     * 
     * @param FollowRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function followReverser(FollowRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $followDTO = FollowDTO::fromCreateRequest($request->validated());
            $isFollowed = $this->followManager->followReverser($followDTO);

            DB::commit();

            return response()->json([
                "message" => "Follow or reverse success.",
                "result" => [
                    "is_followed" => $isFollowed
                ],
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
}
