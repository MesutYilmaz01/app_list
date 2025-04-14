<?php

namespace App\Modules\Authority\Domain\Response;

use App\Modules\Authority\Domain\Aggregate\AuthorityAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class AuthorityUserListResponse implements IBaseResponse
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
            ]);
        }

        return $response;
    }
}
