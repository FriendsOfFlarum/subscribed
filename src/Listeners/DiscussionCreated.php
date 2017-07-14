<?php

namespace Flagrow\Subscribed\Listeners;

use Flagrow\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use Flarum\Api\Serializer\DiscussionBasicSerializer;
use Flarum\Event\ConfigureNotificationTypes;
use Illuminate\Contracts\Events\Dispatcher;

class DiscussionCreated
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureNotificationTypes::class, [$this, 'addType']);
    }

    public function addType(ConfigureNotificationTypes $event)
    {
        $event->add(
            DiscussionCreatedBlueprint::class,
            DiscussionBasicSerializer::class,
            []
        );
    }
}
