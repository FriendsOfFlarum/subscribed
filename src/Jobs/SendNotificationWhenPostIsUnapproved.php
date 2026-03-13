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
use Flarum\Post\Post;
use Flarum\User\User;
use Flarum\Queue\AbstractJob;
use FoF\Subscribed\Blueprints\PostUnapprovedBlueprint;
use Illuminate\Database\Query\Expression;

class SendNotificationWhenPostIsUnapproved extends AbstractJob
{

    public function __construct(protected Post $post)
    {
    }

    public function handle(NotificationSyncer $notifications): void
    {
        $post = $this->post;

        $notify = User::query()
            ->where('users.id', '!=', $post->user_id)
            ->where('preferences', 'regexp', new Expression('\'"notify_postUnapproved_[a-z]+":true\''))
            ->get();

        $notify = $notify->filter(function (User $recipient) use ($post) {
            return $recipient->can('subscribePostUnapproved') && $post->isVisibleTo($recipient);
        });

        $notifications->sync(
            new PostUnapprovedBlueprint($post),
            $notify->all()
        );
    }
}
