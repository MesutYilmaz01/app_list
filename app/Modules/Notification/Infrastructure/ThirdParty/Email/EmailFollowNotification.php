<?

namespace App\Modules\Notification\Infrastructure\ThirdParty\Email;

use App\Models\User;
use App\Modules\Notification\Domain\Interfaces\INotificationProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailFollowNotification extends Notification implements INotificationProvider
{
    use Queueable;

    private User $followedUser;
    private User $ownerUser;

    /**
     * Create a new notification instance.
     * @param User $ownerUser
     * @param User $followedUser
     * 
     * @return void
     */
    public function __construct(User $ownerUser, User $followedUser)
    {
        $this->followedUser = $followedUser;
        $this->ownerUser = $ownerUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //i just send follow mail that's why it's not arrangable. If you want you can choose another template depends on parameters.
        return (new MailMessage)
            ->greeting("Hello {$this->followedUser->username},")
            ->line("{$this->ownerUser->username} who you follow created a new list.")
            ->line('Check out if you wonder!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
