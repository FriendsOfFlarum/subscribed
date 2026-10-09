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
use FoF\Subscribed\Blueprints\PostCreatedBlueprint;
use FoF\Subscribed\Jobs\Concerns\FindsSubscribedUsers;

class SendNotificationWhenPostIsCreated extends AbstractJob
{
    use FindsSubscribedUsers;

    public function __construct(protected Post $post)
    {
    }

    public function handle(NotificationSyncer $notifications): void
    {
        $post = $this->post;

        $notify = $this->subscribedUsers('postCreated', User::query()
            ->where('users.id', '!=', $post->user_id)
        );

        $notify = $notify->filter(function (User $recipient) use ($post) {
            return $recipient->can('subscribePostCreated') && $post->isVisibleTo($recipient);
        });

        $notifications->sync(
            new PostCreatedBlueprint($post),
            $notify->all()
        );
    }
}
