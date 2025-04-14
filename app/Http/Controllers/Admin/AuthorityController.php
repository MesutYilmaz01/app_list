<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Authority\AuthorityCreateRequest;
use App\Http\Requests\Admin\Authority\AuthorityDeleteRequest;
use App\Http\Requests\Admin\Authority\AuthorityShowRequest;
use App\Http\Requests\Admin\Authority\AuthorityUpdateRequest;
use App\Modules\Authority\Application\Manager\AuthorityManager;
use App\Modules\Authority\Domain\DTO\AuthorityDTO;
use App\Modules\Authority\Domain\Response\AuthorityAdminListResponse;
use App\Modules\Authority\Domain\Response\AuthorityAdminResponse;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthorityController extends Controller
{
    public function __construct(
        private AuthorityManager $authorityManager
    ) {}

    /**
     * Gets all authority data
     * 
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function getAll(): JsonResponse
    {
        try {
            $authorities = $this->authorityManager->setResponseType(AuthorityAdminListResponse::class)->getAll();
            return response()->json([
                "message" => "Authority list got successfully.",
                "result" => ["authorties" => $authorities]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Gets authority according to id
     * 
     * @param AuthorityShowRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function show(AuthorityShowRequest $request): JsonResponse
    {
        try {
            $authority = $this->authorityManager->setResponseType(AuthorityAdminResponse::class)->getById($request->authority_id);
            return response()->json([
                "message" => "Authority got successfully.",
                "result" => ["authortiy" => $authority]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Creates a authority 
     * 
     * @param AuthorityCreateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function create(AuthorityCreateRequest $request): JsonResponse
    {
        try {
            $authorityDTO = AuthorityDTO::fromCreateRequest($request->validated());
            $authority = $this->authorityManager->create($authorityDTO);

            $authority = $this->authorityManager->setResponseType(AuthorityAdminResponse::class)->getById($authority->id);
            return response()->json([
                "message" => "Authority created successfully.",
                "result" => ["authortiy" => $authority]
            ], 201);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Updates a authority according to given id
     * 
     * @param AuthorityUpdateRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function update(AuthorityUpdateRequest $request): JsonResponse
    {
        try {
            $authorityDTO = AuthorityDTO::fromUpdateRequest($request->validated());
            $authority = $this->authorityManager->update($request->authority_id, $authorityDTO);
            
            $authority = $this->authorityManager->setResponseType(AuthorityAdminResponse::class)->getById($authority->id);
            return response()->json([
                "message" => "Authority updated successfully.",
                "result" => ["authortiy" => $authority]
            ], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }

    /**
     * Deletes a authority according to given id
     * 
     * @param AuthorityDeleteRequest $request
     * @return JsonRespone
     * 
     * @throws Exception
     */
    public function delete(AuthorityDeleteRequest $request): JsonResponse
    {
        try {
            $this->authorityManager->delete($request->authority_id);
            return response()->json(["message" => "Authority deletion is successfuly completed."], 200);
        } catch (Exception $e) {
            return response()->json(["message" => $e->getMessage()], $e->getCode());
        }
    }
}
