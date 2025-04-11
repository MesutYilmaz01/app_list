<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UserAuthority\UserAuthorityRequest;
use App\Http\Requests\Common\UserAuthority\UserAuthorityUpdateRequest;
use App\Http\Requests\User\UserAuthority\UserAuthorityCreateRequest;
use App\Http\Requests\User\UserAuthority\UserAuthorityDeleteRequest;
use App\Modules\Authority\Application\Manager\UserAuthorityManager;
use App\Modules\Authority\Domain\DTO\UserAuthorityDTO;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserAuthorityController extends Controller
{
    public function __construct(
        private UserAuthorityManager $userAuthorityManager,
    ) {}

    /**
     * Gets a user authority according to given user authority id
     * 
     * @param UserAuthorityRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function show(UserAuthorityRequest $request): JsonResponse
    {
        Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

        try {
            $comment = $this->userAuthorityManager->getById($request->user_authority_id);
            return response()->json([
                "message" => "User authority got successfully.",
                "result" => $comment,
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Creates a user authority according to given data
     * 
     * @param UserAuthorityCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(UserAuthorityCreateRequest $request): JsonResponse
    {
        Gate::authorize('isOwner', [new UserAuthorityEntity(), $request->user_list_id]);
        
        try {
            $userAuthorityDTO = UserAuthorityDTO::fromCreateRequest($request->validated());
            $userAuthority = $this->userAuthorityManager->create($userAuthorityDTO);
            return response()->json([
                "message" => "User authority added successfully.",
                "result" => $userAuthority
            ], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }


    /**
     * Updates a user authority according to given id
     * 
     * @param UserAuthorityUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(UserAuthorityUpdateRequest $request): JsonResponse
    {
        Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

        try {
            $userAuthorityDTO = UserAuthorityDTO::fromUpdateRequest($request->validated());
            $userAuthority = $this->userAuthorityManager->update($request->user_authority_id, $userAuthorityDTO);
            return response()->json([
                "message" => "User authority updated successfully.",
                "result" => $userAuthority
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a user authority according to given id
     * 
     * @param UserAuthorityDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(UserAuthorityDeleteRequest $request): JsonResponse
    {
        Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

        try {
            $this->userAuthorityManager->delete($request->user_authority_id);
            return response()->json(["message" => "User authority deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
