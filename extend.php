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
use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use FoF\Subscribed\Blueprints\PostCreatedBlueprint;
use FoF\Subscribed\Blueprints\PostUnapprovedBlueprint;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use FoF\Subscribed\Listeners\AddPermissions;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\View())
        ->namespace('fof-subscribed', __DIR__.'/resources/views'),

    (new Extend\Notification())
        ->type(DiscussionCreatedBlueprint::class, BasicDiscussionSerializer::class, [])
        ->type(PostCreatedBlueprint::class, BasicPostSerializer::class, [])
        ->type(PostUnapprovedBlueprint::class, BasicPostSerializer::class, [])
        ->type(UserCreatedBlueprint::class, BasicUserSerializer::class, []),

    (new Extend\ApiSerializer(CurrentUserSerializer::class))
        ->attributes(AddPermissions::class),

    (new Extend\Event())
        ->subscribe(Listeners\DiscussionCreated::class)
        ->subscribe(Listeners\PostCreated::class)
        ->subscribe(Listeners\UnapprovedPostCreated::class)
        ->subscribe(Listeners\UserCreated::class),
];
