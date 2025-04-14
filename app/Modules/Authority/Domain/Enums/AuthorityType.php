<?

namespace App\Modules\Authority\Domain\Enums;


enum AuthorityType: int
{
    case SHOW = 1;
    case UPDATE = 2;
    case CREATE = 4;
    case DELETE = 8;
}
