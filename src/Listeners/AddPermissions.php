<?php

namespace FoF\Subscribed\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class AddPermissions
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Serializing::class, [$this, 'prepareApiAttributes']);
    }

    /**
     * @param Serializing $event
     */
    public function prepareApiAttributes(Serializing $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            $event->attributes['subscribeDiscussionCreated'] = $event->actor->can('subscribeDiscussionCreated');
            $event->attributes['subscribeUserCreated'] = $event->actor->can('subscribeUserCreated');
        }
    }
}
