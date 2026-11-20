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

use Flarum\Flags\Flag;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Flarum\Queue\AbstractJob;
use FoF\Subscribed\Blueprints\PostFlaggedBlueprint;
use FoF\Subscribed\Jobs\Concerns\FindsSubscribedUsers;

class SendNotificationWhenPostIsFlagged extends AbstractJob
{
    use FindsSubscribedUsers;

    public function __construct(protected Flag $flag)
    {
    }
    
    public function handle(NotificationSyncer $notifications): void
    {
        $post = $this->flag->post;
        $flag = $this->flag;

        $notify = $this->subscribedUsers('postFlagged', User::query()
            ->where('users.id', '!=', $flag->user_id)
        );

        $notify = $notify->filter(function (User $recipient) use ($post) {
            return $recipient->can('subscribePostFlagged') && $recipient->can('viewFlags', $post->discussion);
        });

        $notifications->sync(
            new PostFlaggedBlueprint($post, $flag),
            $notify->all()
        );
    }
}
