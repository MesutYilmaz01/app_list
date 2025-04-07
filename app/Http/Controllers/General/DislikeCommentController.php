<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Dislike\DislikeCommentRequest;
use App\Modules\Dislike\Application\Manager\DislikeCommentManager;
use App\Modules\Dislike\Domain\DTO\DislikeCommentDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DislikeCommentController extends Controller
{
    public function __construct(
        private DislikeCommentManager $dislikeCommentManager,
    ) {}

    /**
     * Likes or reverse like.
     * 
     * @param DislikeCommentRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function dislikeReverser(DislikeCommentRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dislikeCommentDTO = DislikeCommentDTO::fromCreateRequest($request->validated());
            $isDisliked = $this->dislikeCommentManager->dislikeReverser($dislikeCommentDTO);

            DB::commit();

            return response()->json([
                "message" => "Dislike comment or reverse success.",
                "result" => [
                    "is_disliked" => $isDisliked
                ],
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
}
