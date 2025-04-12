<?

namespace App\Modules\Authority\Domain\Enums;


enum AuthorityType: int
{
    case SHOW = 1;
    case UPDATE = 2;
    case SHOW_UPDATE = 3;
    case DELETE = 4;
    case SHOW_DELETE = 5;
    case UPDATE_DELETE = 6;
    case SHOW_UPDATE_DELETE = 7;
}