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

use Flarum\Post\Event\Posted;
use FoF\Subscribed\Jobs\SendNotificationWhenPostIsCreated;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\Queue;

class PostCreated
{
    public function __construct(protected Queue $queue)
    {
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(Posted::class, [$this, 'whenPosted']);
    }

    public function whenPosted(Posted $event): void
    {
        // We don't want to notify if this is the first post in a new discussion, or if the post
        // is not approved.
        /** @phpstan-ignore-next-line */
        if ($event->post->number === 1 || $event->post->is_approved === false) {
            return;
        }

        $this->queue->push(new SendNotificationWhenPostIsCreated($event->post));
    }
}
