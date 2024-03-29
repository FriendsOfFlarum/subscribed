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

use Flarum\Approval\Event\PostWasApproved;
use Flarum\Discussion\Discussion;
use Flarum\Discussion\Event\Deleted;
use Flarum\Discussion\Event\Restored;
use Flarum\Discussion\Event\Started;
use Flarum\Notification\NotificationSyncer;
use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use FoF\Subscribed\Jobs\SendNotificationWhenDiscussionIsStarted;
use Illuminate\Contracts\Events\Dispatcher;

class DiscussionCreated
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
        $events->listen(Started::class, [$this, 'whenDiscussionWasStarted']);
        $events->listen(PostWasApproved::class, [$this, 'whenDiscussionWasApproved']);
        $events->listen(Deleted::class, [$this, 'whenDiscussionWasDeleted']);
        $events->listen(Restored::class, [$this, 'whenDiscussionWasRestored']);
    }

    public function whenDiscussionWasStarted(Started $event)
    {
        /** @phpstan-ignore-next-line */
        if ($event->discussion->is_approved === false) {
            return;
        }

        resolve('flarum.queue.connection')->push(
            new SendNotificationWhenDiscussionIsStarted($event->discussion)
        );
    }

    public function whenDiscussionWasApproved(PostWasApproved $event)
    {
        if ($event->post->number !== 1) {
            return;
        }

        resolve('flarum.queue.connection')->push(
            new SendNotificationWhenDiscussionIsStarted($event->post->discussion)
        );
    }

    /**
     * @param Deleted $event
     */
    public function whenDiscussionWasDeleted(Deleted $event)
    {
        $this->notifications->delete($this->getNotification($event->discussion));
    }

    /**
     * @param Restored $event
     */
    public function whenDiscussionWasRestored(Restored $event)
    {
        $this->notifications->restore($this->getNotification($event->discussion));
    }

    /**
     * @param Discussion $discussion
     *
     * @return DiscussionCreatedBlueprint
     */
    protected function getNotification(Discussion $discussion)
    {
        return new DiscussionCreatedBlueprint($discussion);
    }
}
