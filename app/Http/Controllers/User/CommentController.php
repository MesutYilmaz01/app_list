<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Comment\CommentCreateRequest;
use App\Http\Requests\Common\Comment\CommentDeleteRequest;
use App\Http\Requests\Common\Comment\CommentShowRequest;
use App\Http\Requests\User\Comment\CommentUpdateRequest;
use App\Modules\Comment\Application\Manager\CommentManager;
use App\Modules\Comment\Domain\DTO\CommentDTO;
use App\Modules\Comment\Domain\Entities\CommentEntity;
use App\Modules\Comment\Domain\Response\CommentUserResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
        Gate::authorize('isOwner', [new CommentEntity(), $request->comment_id]);

        try {
            $comment = $this->commentManager->setResponseType(CommentUserResponse::class)->show($request->comment_id);
            return response()->json([
                "message" => "Comment got successfully.",
                "result" => $comment,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Creates a comment according to given data
     * 
     * @param CommentCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(CommentCreateRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            $commentDTO = CommentDTO::fromCreateRequest($request->validated());
            $comment = $this->commentManager->create($commentDTO);
            DB::commit();

            $comment = $this->commentManager->setResponseType(CommentUserResponse::class)->show($comment->id);

            return response()->json([
                "message" => "Comment added with it's item successfully.",
                "result" => $comment
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(["message" => $e->getMessage()], $e->getCode());
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
        Gate::authorize('isOwner', [new CommentEntity(), $request->comment_id]);

        try {
            $commentDTO = CommentDTO::fromUpdateRequest($request->validated());
            $comment = $this->commentManager->setResponseType(CommentUserResponse::class)->update($request->comment_id, $commentDTO);
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
        Gate::authorize('isOwner', [new CommentEntity(), $request->comment_id]);

        try {
            $this->commentManager->delete($request->comment_id);
            return response()->json(["message" => "Comment deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
