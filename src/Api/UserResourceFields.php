<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Api;

use Flarum\Api\Context;
use Flarum\Api\Schema;
use Flarum\Extension\ExtensionManager;
use Flarum\User\User;

class UserResourceFields
{
    public function __construct(protected ExtensionManager $extensions)
    {
    }

    public function __invoke(): array
    {
        $fields = [
            Schema\Boolean::make('canSubscribeDiscussionCreated')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->can('subscribeDiscussionCreated')),

            Schema\Boolean::make('canSubscribePostCreated')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->can('subscribePostCreated')),

            Schema\Boolean::make('canSubscribeUserCreated')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->can('subscribeUserCreated')),
        ];

        if ($this->extensions->isEnabled('flarum-approval')) {
            $fields[] = Schema\Boolean::make('canSubscribePostUnapproved')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->can('subscribePostUnapproved'));
        }

        if ($this->extensions->isEnabled('flarum-flags')) {
            $fields[] = Schema\Boolean::make('canSubscribePostFlagged')
                ->visible(fn (User $user, Context $context) => $context->getActor()->id === $user->id)
                ->get(fn (User $user, Context $context) => $context->getActor()->can('subscribePostFlagged'));
        }

        return $fields;
    }
}
