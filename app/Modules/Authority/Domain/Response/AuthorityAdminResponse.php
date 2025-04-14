<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\AuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class AuthorityAdminResponse implements IBaseResponse
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
        $response = [
            "id" => $this->authorityAggregate->getAuthorityEntity()->id,
            "code" => $this->authorityAggregate->getAuthorityEntity()->code,
            "created_at" => $this->authorityAggregate->getAuthorityEntity()->created_at->toDateTimeString(),
            "updated_at" => $this->authorityAggregate->getAuthorityEntity()->updated_at->toDateTimeString(),
            "deleted_at" => $this->authorityAggregate->getAuthorityEntity()->deleted_at ? $$this->userAuthorityAggregate->getAuthorityEntity()->deleted_at->toDateTimeString() : null,
        ];

        return $response;
    }
}
