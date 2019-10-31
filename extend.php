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

use Flarum\Api\Event\Serializing;
use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
    (new Extend\Locales(__DIR__.'/resources/locale')),
    function (Dispatcher $events, Factory $view) {
        $events->listen(Serializing::class, Listeners\AddPermissions::class);
        /*
         * Events
         */
        $events->subscribe(Listeners\DiscussionCreated::class);
        $events->subscribe(Listeners\UnapprovedPostCreated::class);
        $events->subscribe(Listeners\UserCreated::class);
        /*
         *  Views
         */
        $view->addNamespace('fof-subscribed', __DIR__.'/resources/views');
    },
];
