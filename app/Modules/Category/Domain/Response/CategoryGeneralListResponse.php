<?php

namespace App\Modules\Category\Domain\Response;

use App\Modules\Shared\Responses\Interface\IBaseResponse;
use App\Modules\Category\Domain\Aggregate\CategoryAggregate;

class CategoryGeneralListResponse implements IBaseResponse
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
            ]);
        }

        return $response;
    }
}
