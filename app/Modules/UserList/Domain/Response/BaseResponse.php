<?php

namespace App\Modules\UserList\Domain\Response;

abstract class BaseResponse
{

    abstract function getResponse(): array;

    abstract function fill(): self;
}
