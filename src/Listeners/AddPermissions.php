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

use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\User\User;

class AddPermissions
{
    /**
     * @param ForumSerializer $serializer
     */
    public function __invoke(CurrentUserSerializer $serializer, User $user, array $attributes): array
    {
        $attributes['canSubscribeDiscussionCreated'] = $serializer->getActor()->can('subscribeDiscussionCreated');
        $attributes['canSubscribePostCreated'] = $serializer->getActor()->can('subscribePostCreated');
        $attributes['canSubscribePostUnapproved'] = $serializer->getActor()->can('subscribePostUnapproved');
        $attributes['canSubscribeUserCreated'] = $serializer->getActor()->can('subscribeUserCreated');

        return $attributes;
    }
}
