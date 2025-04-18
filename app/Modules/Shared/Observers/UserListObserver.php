<?

namespace App\Modules\Shared\Observers;

use App\Models\UserList;
use App\Modules\Shared\Events\UserList\UserListCreatedNotificationEvent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class UserListObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the UserList "created" event.
     *
     * @param  \App\Models\UserList  $user
     * @return void
     */
    public function created(UserList $userList)
    {
        UserListCreatedNotificationEvent::dispatch($userList);
    }

    /**
     * Handle the UserList "updated" event.
     *
     * @param  \App\Models\UserList  $user
     * @return void
     */
    public function updated(UserList $userList)
    {
        //
    }

    /**
     * Handle the UserList "deleted" event.
     *
     * @param  \App\Models\UserList  $user
     * @return void
     */
    public function deleted(UserList $userList)
    {
        //
    }

    /**
     * Handle the UserList "restored" event.
     *
     * @param  \App\Models\UserList  $user
     * @return void
     */
    public function restored(UserList $userList)
    {
        //
    }

    /**
     * Handle the UserList "force deleted" event.
     *
     * @param  \App\Models\UserList  $user
     * @return void
     */
    public function forceDeleted(UserList $userList)
    {
        //
    }
}
