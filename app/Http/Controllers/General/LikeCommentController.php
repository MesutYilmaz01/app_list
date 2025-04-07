<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Like\LikeCommentRequest;
use App\Modules\Like\Application\Manager\LikeCommentManager;
use App\Modules\Like\Domain\DTO\LikeCommentDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LikeCommentController extends Controller
{
    public function __construct(
        private LikeCommentManager $likeCommentManager,
    ) {}

    /**
     * Likes or reverse like.
     * 
     * @param LikeCommentRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function likeReverser(LikeCommentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $likeCommentDTO = LikeCommentDTO::fromCreateRequest($request->validated());
            $isLiked = $this->likeCommentManager->likeReverser($likeCommentDTO);

            DB::commit();

            return response()->json([
                "message" => "Like comment or reverse success.",
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
