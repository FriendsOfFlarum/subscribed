<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Jobs;

use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Flarum\Queue\AbstractJob;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use FoF\Subscribed\Jobs\Concerns\FiltersBySubscription;
use Illuminate\Database\Eloquent\Builder;

class SendNotificationWhenUserIsCreated extends AbstractJob
{
    use FiltersBySubscription;

    public function __construct(protected User $user)
    {
    }

    public function handle(NotificationSyncer $notifications): void
    {
        $user = $this->user;

        $notify = User::query()
            ->where('users.id', '!=', $user->id)
            ->where('users.is_email_confirmed', '=', 1)
            ->tap(fn (Builder $query) => $this->whereSubscribedTo($query, 'userCreated'))
            ->get();

        $notify = $notify->filter(function (User $recipient) {
            return $recipient->can('subscribeUserCreated');
        });

        $notifications->sync(
            new UserCreatedBlueprint($user),
            $notify->all()
        );
    }
}
