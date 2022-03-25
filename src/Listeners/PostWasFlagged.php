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

use Flarum\Flags\Event\Created;
use Flarum\Flags\Event\Deleting;
use Flarum\Flags\Flag;
use Flarum\Notification\NotificationSyncer;
use FoF\Subscribed\Blueprints\PostFlaggedBlueprint;
use FoF\Subscribed\Jobs\SendNotificationWhenPostIsFlagged;
use Illuminate\Contracts\Events\Dispatcher;

class PostWasFlagged
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
        $events->listen(Created::class, [$this, 'whenFlagged']);
        $events->listen(Deleting::class, [$this, 'whenFlagDismissed']);
    }
    
    public function whenFlagged(Created $event): void
    {
        resolve('flarum.queue.connection')->push(
            new SendNotificationWhenPostIsFlagged($event->flag)
        );
    }

    public function whenFlagDismissed(Deleting $event): void
    {
        // remove notifications for this flag when it is dismissed
        $this->notifications->delete($this->getNotification($event->flag->post, $event->flag));
    }

    protected function getNotification($post, Flag $flag)
    {
        return new PostFlaggedBlueprint($post, $flag);
    }
}
