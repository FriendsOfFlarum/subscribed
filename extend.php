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
use Flarum\Api\Context;
use Flarum\Api\Endpoint;
use Flarum\Api\Resource;
use Flarum\Api\Schema;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\View())
        ->namespace('fof-subscribed', __DIR__.'/resources/views'),

    (new Extend\Notification())
        ->type(Blueprints\DiscussionCreatedBlueprint::class, [])
        ->type(Blueprints\PostCreatedBlueprint::class, [])
        ->type(Blueprints\PostUnapprovedBlueprint::class, [])
        ->type(Blueprints\UserCreatedBlueprint::class, [])
        ->type(Blueprints\PostFlaggedBlueprint::class, []),

    // @TODO: Replace with the new implementation https://docs.flarum.org/2.x/extend/api#extending-api-resources
    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attributes(AddPermissions::class),

    (new Extend\Event())
        ->subscribe(Listeners\DiscussionCreated::class)
        ->subscribe(Listeners\PostCreated::class)
        ->subscribe(Listeners\UnapprovedPostCreated::class)
        ->subscribe(Listeners\UserCreated::class)
        ->subscribe(Listeners\PostWasFlagged::class),
];
