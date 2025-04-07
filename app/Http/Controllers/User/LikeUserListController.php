<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Like\LikeUserListRequest;
use App\Modules\Like\Application\Manager\LikeUserListManager;
use App\Modules\Like\Domain\DTO\LikeUserListDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LikeUserListController extends Controller
{
    public function __construct(
        private LikeUserListManager $likeUserListManager,
    ) {}

    /**
     * Likes or reverse like.
     * 
     * @param LikeUserListRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function likeReverser(LikeUserListRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $likeUserListDTO = LikeUserListDTO::fromCreateRequest($request->validated());
            $isLiked = $this->likeUserListManager->likeReverser($likeUserListDTO);

            DB::commit();

            return response()->json([
                "message" => "Like or reverse success.",
                "result" => [
                    "is_liked" => $isLiked
                ],
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
}
