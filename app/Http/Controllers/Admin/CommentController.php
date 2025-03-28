<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Comment\CommentUpdateRequest;
use App\Http\Requests\Common\Comment\CommentDeleteRequest;
use App\Http\Requests\Common\Comment\CommentShowRequest;
use App\Modules\Comment\Application\Manager\CommentManager;
use App\Modules\Comment\Domain\DTO\CommentDTO;
use App\Modules\Comment\Domain\Response\CommentAdminResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(
        private CommentManager $commentManager,
    ) {}

    /**
     * Gets a comment according to given comment id
     * 
     * @param CommentShowRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function show(CommentShowRequest $request): JsonResponse
    {
        try {
            $comment = $this->commentManager->setResponseType(CommentAdminResponse::class)->show($request->comment_id);
            return response()->json([
                "message" => "Comment got successfully.",
                "result" => $comment,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Updates a comment according to given id
     * 
     * @param CommentUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(CommentUpdateRequest $request): JsonResponse
    {
        try {
            $commentDTO = CommentDTO::fromUpdateRequest($request->validated());
            $comment = $this->commentManager->setResponseType(CommentAdminResponse::class)->update($request->comment_id, $commentDTO);
            return response()->json([
                "message" => "Comment updated successfully.",
                "result" => $comment
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a comment according to given id
     * 
     * @param CommentDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(CommentDeleteRequest $request): JsonResponse
    {
        try {
            $this->commentManager->delete($request->comment_id);
            return response()->json(["message" => "Comment deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
