<?php

namespace App\Modules\Notification\Application\Listeners;

use App\Models\Follow;
use App\Modules\Follow\Application\Manager\FollowManager;
use App\Modules\Notification\Domain\Enums\NotificationType;
use App\Modules\Notification\Domain\Interfaces\INotificationProvider;
use App\Modules\Notification\Infrastructure\ThirdParty\Email\EmailFollowNotification;
use App\Modules\Shared\Events\UserList\UserListCreatedNotificationEvent;
use Exception;

class UserListCreatedNotificationListener
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private FollowManager $followManager
    ) {}

    /**
     * Handle the event.
     */
    public function handle(UserListCreatedNotificationEvent $event): void
    {
        try {
            $follows = $this->followManager->getAllByAttributes([
                "followed_user_id" => auth()->user()->id
            ]);

            if (!count($follows)) {
                return;
            }

            foreach ($follows as $follow) {
                //provider may arrange according to user preferance. I gave it static for now.
                $notificationProvider = $this->selectProvider(NotificationType::MAIL, $follow);
                $follow->followedUser->notify($notificationProvider);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    private function selectProvider(NotificationType $notificationType, Follow $follow): INotificationProvider
    {
        switch ($notificationType->value) {
            case NotificationType::MAIL:
                return new EmailFollowNotification($follow->user, $follow->followedUser);
            default:
                return new EmailFollowNotification($follow->user, $follow->followedUser);
        }
    }
}
