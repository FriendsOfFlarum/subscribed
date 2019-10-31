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

use Flarum\Api\Event\Serializing;
use Flarum\Api\Serializer\ForumSerializer;

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
