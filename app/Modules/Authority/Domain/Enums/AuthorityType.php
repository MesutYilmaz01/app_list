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
    case CREATE = 8;
    case SHOW_CREATE = 9;
    case UPDATE_CREATE = 10;
    case SHOW_UPDATE_CREATE = 11;
    case CREATE_DELETE = 12;
    case SHOW_DELETE_CREATE = 13;
    case UPDATE_DELETE_CREATE = 14;
    case SHOW_UPDATE_CREATE_DELETE = 15;
}