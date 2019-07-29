<?php

namespace FoF\Subscribed\Listeners;

use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\User\Event\Deleted;
use Flarum\User\Event\Registered;
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
        $events->listen(Registered::class, [$this, 'whenUserRegistered']);
        $events->listen(Deleted::class, [$this, 'whenUserWasDeleted']);
    }

    /**
     * @param ConfigureNotificationTypes $event
     */
    public function addType(ConfigureNotificationTypes $event)
    {
        $event->add(
            UserCreatedBlueprint::class,
            BasicUserSerializer::class,
            []
        );
    }

    /**
     * @param Registered $event
     */
    public function whenUserRegistered(Registered $event)
    {
        $user = $event->user;

        $notify = User::query()
            ->where('users.id', '!=', $user->id)
            ->where('users.is_email_confirmed', '=', 1)
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
     * @param Deleted $event
     */
    public function whenUserWasDeleted(Deleted $event)
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
