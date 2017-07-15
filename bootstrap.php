<?php

namespace Flagrow\Subscribed;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\View\Factory;

return function(Dispatcher $events, Factory $views) {
    $events->subscribe(Listeners\AddClientAssets::class);

    $events->subscribe(Listeners\DiscussionCreated::class);

    $views->addNamespace('flagrow-subscribed', __DIR__.'/resources/views');
};
