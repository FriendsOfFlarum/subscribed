<?php

namespace FoF\Subscribed\Listeners;

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;
use Illuminate\Contracts\Events\Dispatcher;

class AddPermissions
{
    /**
     * @param Serializing $event
     */
    public function handle(Serializing $event)
    {
        if ($event->isSerializer(ForumSerializer::class)) {
            $event->attributes['subscribeDiscussionCreated'] = $event->actor->can('subscribeDiscussionCreated');
            $event->attributes['subscribePostUnapproved'] = $event->actor->can('subscribePostUnapproved');
            $event->attributes['subscribeUserCreated'] = $event->actor->can('subscribeUserCreated');
        }
    }
}
