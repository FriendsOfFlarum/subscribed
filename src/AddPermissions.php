<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed;

use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extension\ExtensionManager;
use Flarum\User\User;

class AddPermissions
{
    /**
     * @var ExtensionManager
     */
    protected $extensions;
    
    public function __construct(ExtensionManager $extensions)
    {
        $this->extensions = $extensions;
    }
    
    /**
     * @param ForumSerializer $serializer
     */
    public function __invoke(CurrentUserSerializer $serializer, User $user, array $attributes): array
    {
        $attributes['canSubscribeDiscussionCreated'] = $serializer->getActor()->can('subscribeDiscussionCreated');
        $attributes['canSubscribePostCreated'] = $serializer->getActor()->can('subscribePostCreated');
        $attributes['canSubscribeUserCreated'] = $serializer->getActor()->can('subscribeUserCreated');

        if ($this->extensions->isEnabled('flarum-approval')) {
            $attributes['canSubscribePostUnapproved'] = $serializer->getActor()->can('subscribePostUnapproved');
        }

        if ($this->extensions->isEnabled('flarum-flags')) {
            $attributes['canSubscribePostFlagged'] = $serializer->getActor()->can('subscribePostFlagged');
        }

        return $attributes;
    }
}
