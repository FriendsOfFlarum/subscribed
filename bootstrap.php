<?php

namespace Flagrow\Subscribed;

use Illuminate\Contracts\Events\Dispatcher;

return function(Dispatcher $events) {
    $events->subscribe(Listeners\AddClientAssets::class);

    $events->subscribe(Listeners\DiscussionCreated::class);
};
