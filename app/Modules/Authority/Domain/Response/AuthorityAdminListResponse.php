<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\AuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class AuthorityAdminListResponse implements IBaseResponse
{
    public function __construct(
        private AuthorityAggregate $authorityAggregate
    ) {}

    /**
     * Fills authorityAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [];
        foreach ($this->authorityAggregate->getAuthorityList() as $authority) {
            array_push($response, [
                "id" => $authority->id,
                "code" => $authority->code,
                "created_at" => $authority->created_at->toDateTimeString(),
                "updated_at" => $authority->updated_at->toDateTimeString(),
                "deleted_at" => $authority->deleted_at ? $authority->deleted_at->toDateTimeString() : null,
            ]);
        }

        return $response;
    }
}
