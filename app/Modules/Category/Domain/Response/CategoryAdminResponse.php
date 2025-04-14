<?php

namespace App\Modules\Category\Domain\Response;

use App\Modules\Category\Domain\Aggregate\CategoryAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class CategoryAdminResponse implements IBaseResponse
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
            "created_at" => $this->categoryAggregate->getCategoryEntity()->created_at,
            "updated_at" => $this->categoryAggregate->getCategoryEntity()->updated_at,
            "deleted_at" => $this->categoryAggregate->getCategoryEntity()->deleted_at ? $this->categoryAggregate->getCategoryEntity()->deleted_at : null,
        ];

        return $response;
    }
}
