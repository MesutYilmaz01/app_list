<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Dislike\DislikeUserListRequest;
use App\Modules\Dislike\Application\Manager\DislikeUserListManager;
use App\Modules\Dislike\Domain\DTO\DislikeUserListDTO;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DislikeUserListController extends Controller
{
    public function __construct(
        private DislikeUserListManager $dislikeUserListManager,
    ) {}

    /**
     * Likes or reverse like.
     * 
     * @param DislikeUserListRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function dislikeReverser(DislikeUserListRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $dislikeUserListDTO = DislikeUserListDTO::fromCreateRequest($request->validated());
            $isDisliked = $this->dislikeUserListManager->dislikeReverser($dislikeUserListDTO);

            DB::commit();

            return response()->json([
                "message" => "Dislike user list or reverse success.",
                "result" => [
                    "is_liked" => $isDisliked
                ],
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }
}
