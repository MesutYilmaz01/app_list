<?php

namespace App\Modules\Category\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\Category\Domain\Aggregate\CategoryAggregate;

class CategoryGeneralResponse implements IBaseResponse
{
    public function __construct(
        private CategoryAggregate $categoryAggregate
    ) {}

    /**
     * Fills commentAggregate according to this response type.
     *
     * @return array
     */
    public function fill(): array
    {
        $response = [
            "id" => $this->categoryAggregate->getCategoryEntity()->id,
            "name" => $this->categoryAggregate->getCategoryEntity()->name,
        ];

        return $response;
    }
}
