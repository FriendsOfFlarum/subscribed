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

use Flarum\Api\Serializer\ForumSerializer;

class AddPermissions
{
    /**
     * @param ForumSerializer $serializer
     */
    public function __invoke(ForumSerializer $serializer)
    {
        $attributes['subscribeDiscussionCreated'] = $serializer->getActor()->can('subscribeDiscussionCreated');
        $attributes['subscribePostUnapproved'] = $serializer->getActor()->can('subscribePostUnapproved');
        $attributes['subscribeUserCreated'] = $serializer->getActor()->can('subscribeUserCreated');

        return $attributes;
    }
}
