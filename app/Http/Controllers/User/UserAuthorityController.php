<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\UserAuthority\UserAuthorityRequest;
use App\Http\Requests\Common\UserAuthority\UserAuthorityUpdateRequest;
use App\Http\Requests\Common\UserAuthority\UserAuthorityUserListRequest;
use App\Http\Requests\User\UserAuthority\UserAuthorityCreateRequest;
use App\Http\Requests\User\UserAuthority\UserAuthorityDeleteRequest;
use App\Modules\Authority\Application\Manager\UserAuthorityManager;
use App\Modules\Authority\Domain\DTO\UserAuthorityDTO;
use App\Modules\Authority\Domain\Entities\UserAuthorityEntity;
use App\Modules\Authority\Domain\Response\UserAuthorityUserListResponse;
use App\Modules\Authority\Domain\Response\UserAuthorityUserResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
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
        try {
            Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

            $userAuthority = $this->userAuthorityManager->setResponseType(UserAuthorityUserResponse::class)->getById($request->user_authority_id);
            return response()->json([
                "message" => "User authority got successfully.",
                "result" => ["user_authority" => $userAuthority],
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], (int)$e->getCode());
        }
    }

    /**
     * Gets user authorities according to given user list id
     * 
     * @param UserAuthorityRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getAllForUserList(UserAuthorityUserListRequest $request): JsonResponse
    {
        try {
            Gate::authorize('isOwner', [new UserAuthorityEntity(), $request->user_list_id]);

            $userAuthorities = $this->userAuthorityManager->setResponseType(UserAuthorityUserListResponse::class)->getAllByAttributes($request->user_list_id);
            return response()->json([
                "message" => "User authority list got successfully.",
                "result" => ["user_authorities" => $userAuthorities],
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
        try {
            Gate::authorize('isOwner', [new UserAuthorityEntity(), $request->user_list_id]);

            DB::beginTransaction();

            $userAuthorityDTO = UserAuthorityDTO::fromCreateRequest($request->validated());
            $userAuthority = $this->userAuthorityManager->create($userAuthorityDTO);

            DB::commit();
            return response()->json([
                "message" => "User authority added successfully.",
                "result" => ["user_authority" => $userAuthority],
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
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
        try {
            Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

            $userAuthorityDTO = UserAuthorityDTO::fromUpdateRequest($request->validated());
            $userAuthority = $this->userAuthorityManager->update($request->user_authority_id, $userAuthorityDTO);
            return response()->json([
                "message" => "User authority updated successfully.",
                "result" => ["user_authority" => $userAuthority],
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
        try {
            Gate::authorize('isOwnerUserAuthority', [new UserAuthorityEntity(), $request->user_authority_id]);

            $this->userAuthorityManager->delete($request->user_authority_id);
            return response()->json(["message" => "User authority deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
