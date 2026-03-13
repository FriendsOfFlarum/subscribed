<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Listeners;

use Flarum\Notification\NotificationSyncer;
use Flarum\User\Event\Deleted;
use Flarum\User\Event\Registered;
use Flarum\User\User;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use FoF\Subscribed\Jobs\SendNotificationWhenUserIsCreated;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\Queue;

class UserCreated
{
    public function __construct(
        protected NotificationSyncer $notifications,
        protected Queue $queue,
    ) {
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Registered::class, [$this, 'whenUserRegistered']);
        $events->listen(Deleted::class, [$this, 'whenUserWasDeleted']);
    }

    /**
     * @param Registered $event
     */
    public function whenUserRegistered(Registered $event): void
    {
        $this->queue->push(new SendNotificationWhenUserIsCreated($event->user));
    }

    /**
     * @param Deleted $event
     */
    public function whenUserWasDeleted(Deleted $event): void
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
