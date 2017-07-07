<?php

namespace Flagrow\AutoConfirmFix;

use Illuminate\Contracts\Events\Dispatcher;

return function(Dispatcher $events) {
    $events->subscribe(Listeners\PreventsException::class);
};
