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

use Flarum\Api\Serializer\BasicDiscussionSerializer;
use Flarum\Api\Serializer\BasicPostSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\CurrentUserSerializer;
use Flarum\Extend;
use FoF\Subscribed\Blueprints;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\View())
        ->namespace('fof-subscribed', __DIR__.'/resources/views'),

    (new Extend\Notification())
        ->type(Blueprints\DiscussionCreatedBlueprint::class, BasicDiscussionSerializer::class, [])
        ->type(Blueprints\PostCreatedBlueprint::class, BasicPostSerializer::class, [])
        ->type(Blueprints\PostUnapprovedBlueprint::class, BasicPostSerializer::class, [])
        ->type(Blueprints\UserCreatedBlueprint::class, BasicUserSerializer::class, [])
        ->type(Blueprints\PostFlaggedBlueprint::class, BasicPostSerializer::class, []),

    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attributes(AddPermissions::class),

    (new Extend\Event())
        ->subscribe(Listeners\DiscussionCreated::class)
        ->subscribe(Listeners\PostCreated::class)
        ->subscribe(Listeners\UnapprovedPostCreated::class)
        ->subscribe(Listeners\UserCreated::class)
        ->subscribe(Listeners\PostWasFlagged::class),
];
