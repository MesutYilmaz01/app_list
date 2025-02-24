<?

namespace App\Modules\UserList\Domain\Enums;


enum ShareType: int
{
    case PUBLIC = 1;
    case NOT_PUBLIC = 0;
}