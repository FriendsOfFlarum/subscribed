<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Listeners;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\Event\Deleted;
use Flarum\User\Event\Registered;
use Flarum\User\User;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use FoF\Subscribed\Jobs\SendNotificationWhenUserIsCreated;
use Illuminate\Contracts\Events\Dispatcher;

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
        app('flarum.queue.connection')->push(
            new SendNotificationWhenUserIsCreated($event->user)
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
     *
     * @return UserCreatedBlueprint
     */
    protected function getNotification(User $user)
    {
        return new UserCreatedBlueprint($user);
    }
}
