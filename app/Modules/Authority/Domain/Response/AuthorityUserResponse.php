<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\AuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class AuthorityUserResponse implements IBaseResponse
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
        ];

        return $response;
    }
}
