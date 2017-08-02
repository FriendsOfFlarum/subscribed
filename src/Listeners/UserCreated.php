<?php

namespace Flagrow\Subscribed\Listeners;

use Flagrow\Subscribed\Blueprints\UserCreatedBlueprint;
use Flarum\Api\Serializer\UserBasicSerializer;
use Flarum\Core\Notification\NotificationSyncer;
use Flarum\Core\User;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Event\UserWasDeleted;
use Flarum\Event\UserWasRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Query\Expression;

class UserCreated
{

    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    /**
     * @param NotificationSyncer $notifications
     */
    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureNotificationTypes::class, [$this, 'addType']);
        $events->listen(UserWasRegistered::class, [$this, 'whenUserRegistered']);
        $events->listen(UserWasDeleted::class, [$this, 'whenUserWasDeleted']);
    }

    /**
     * @param ConfigureNotificationTypes $event
     */
    public function addType(ConfigureNotificationTypes $event)
    {
        $event->add(
            UserCreatedBlueprint::class,
            UserBasicSerializer::class,
            []
        );
    }

    /**
     * @param UserWasRegistered $event
     */
    public function whenUserRegistered(UserWasRegistered $event)
    {
        $user = $event->user;

        $notify = User::query()
            ->where('users.id', '!=', $user->id)
            ->where('users.is_activated', '=', 1)
            ->where('preferences', 'regexp', new Expression('\'"notify_userCreated_[a-z]+":true\''))
            ->get();

        $notify = $notify->filter(function (User $recipient) {
            return $recipient->can('subscribeUserCreated');
        });

        $this->notifications->sync(
            $this->getNotification($user),
            $notify->all()
        );
    }

    /**
     * @param UserWasDeleted $event
     */
    public function whenUserWasDeleted(UserWasDeleted $event)
    {
        $this->notifications->delete($this->getNotification($event->user));
    }

    /**
     * @param User $user
     * @return UserCreatedBlueprint
     */
    protected function getNotification(User $user)
    {
        return new UserCreatedBlueprint($user);
    }
}
