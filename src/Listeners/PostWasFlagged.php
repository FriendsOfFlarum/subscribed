<?php

namespace FoF\Subscribed\Listeners;

use Flarum\Flags\Event\Created;
use FoF\Subscribed\Jobs\SendNotificationWhenPostIsFlagged;

class PostWasFlagged
{
    public function handle(Created $event): void
    {
        resolve('flarum.queue.connection')->push(
            new SendNotificationWhenPostIsFlagged($event->flag)
        );
    }
}
