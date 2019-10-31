<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Jobs;

use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Expression;
use Illuminate\Queue\SerializesModels;

class SendNotificationWhenUserIsCreated implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(NotificationSyncer $notifications)
    {
        $user = $this->user;

        $notify = User::query()
            ->where('users.id', '!=', $user->id)
            ->where('users.is_email_confirmed', '=', 1)
            ->where('preferences', 'regexp', new Expression('\'"notify_userCreated_[a-z]+":true\''))
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
