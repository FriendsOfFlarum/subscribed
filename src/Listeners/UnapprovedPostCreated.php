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
use Flarum\Notification\NotificationSyncer;
use Flarum\Post\Event\Deleted;
use Flarum\Post\Event\Posted;
use Flarum\Post\Post;
use FoF\Subscribed\Blueprints\PostUnapprovedBlueprint;
use FoF\Subscribed\Jobs\SendNotificationWhenPostIsUnapproved;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Notify admins of posts that need approval (requires flarum/approval).
 */
class UnapprovedPostCreated
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
        $events->listen(Posted::class, [$this, 'whenPostWasPosted']);
        $events->listen(Deleted::class, [$this, 'whenPostWasDeleted']);
        $events->listen(PostWasApproved::class, [$this, 'whenPostWasApproved']);
    }

    public function whenPostWasPosted(Posted $event)
    {
        if ($event->post->is_approved !== false) {
            return;
        }

        resolve('flarum.queue.connection')->push(
            new SendNotificationWhenPostIsUnapproved($event->post)
        );
    }

    public function whenPostWasDeleted(Deleted $event)
    {
        $this->notifications->delete($this->getNotification($event->post));
    }

    public function whenPostWasApproved(PostWasApproved $event)
    {
        $this->notifications->delete($this->getNotification($event->post));
    }

    /**
     * @param Post $post
     *
     * @return PostUnapprovedBlueprint
     */
    protected function getNotification(Post $post)
    {
        return new PostUnapprovedBlueprint($post);
    }
}
