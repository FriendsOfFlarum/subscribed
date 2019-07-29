<?php

namespace FoF\Subscribed;

use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    (new Extend\Locales(__DIR__ . '/resources/locale')),
    function (Dispatcher $events, Factory $view) {
        $events->subscribe(Listeners\AddPermissions::class);
        /**
         * Events
         */
        $events->subscribe(Listeners\DiscussionCreated::class);
        $events->subscribe(Listeners\UserCreated::class);
        /**
         *  Views
         */
        $view->addNamespace('fof-subscribed', __DIR__ . '/resources/views');
    }
];
