<?php

namespace App\Modules\Category\Domain\Response;

use App\Modules\Category\Domain\Aggregate\CategoryAggregate;
use App\Modules\Shared\Responses\Interface\IBaseResponse;

class CategoryAdminListResponse implements IBaseResponse
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
        $response = [];
        foreach ($this->categoryAggregate->getCategoryList() as $category) {
            array_push($response, [
                "id" => $category->id,
                "name" => $category->name,
                "created_at" => $category->created_at,
                "updated_at" => $category->updated_at,
                "deleted_at" => $category->deleted_at ? $category->deleted_at : null,
            ]);
        }

        return $response;
    }
}
