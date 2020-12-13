<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed;

use Flarum\Api\Serializer\BasicDiscussionSerializer;
use Flarum\Api\Serializer\BasicPostSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use FoF\Subscribed\Blueprints\PostUnapprovedBlueprint;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use FoF\Subscribed\Listeners\AddPermissions;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Locales(__DIR__.'/resources/locale')),

    (new Extend\View())
        ->namespace('fof-subscribed', __DIR__.'/resources/views'),

    (new Extend\Notification())
        ->type(DiscussionCreatedBlueprint::class, BasicDiscussionSerializer::class, [])
        ->type(PostUnapprovedBlueprint::class, BasicPostSerializer::class, [])
        ->type(UserCreatedBlueprint::class, BasicUserSerializer::class, []),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->mutate(AddPermissions::class),

    function (Dispatcher $events) {
        /*
         * Events
         */
        $events->subscribe(Listeners\DiscussionCreated::class);
        $events->subscribe(Listeners\UnapprovedPostCreated::class);
        $events->subscribe(Listeners\UserCreated::class);
    },
];
