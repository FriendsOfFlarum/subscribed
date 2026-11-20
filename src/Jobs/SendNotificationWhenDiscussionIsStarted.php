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

use Flarum\Discussion\Discussion;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Flarum\Queue\AbstractJob;
use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use FoF\Subscribed\Jobs\Concerns\FindsSubscribedUsers;

class SendNotificationWhenDiscussionIsStarted extends AbstractJob
{
    use FindsSubscribedUsers;

    public function __construct(protected Discussion $discussion)
    {
    }

    public function handle(NotificationSyncer $notifications): void
    {
        $discussion = $this->discussion;

        $notify = $this->subscribedUsers('discussionCreated', User::query()
            ->where('users.id', '!=', $discussion->user_id)
        );

        $notify = $notify->filter(function (User $recipient) use ($discussion) {
            return $recipient->can('subscribeDiscussionCreated') && $discussion->newQuery()->whereVisibleTo($recipient)->find($discussion->id) && !$discussion->stateFor($recipient)->last_read_post_number;
        });

        $post = $discussion->posts()->where('number', 1)->first();

        $notifications->sync(
            new DiscussionCreatedBlueprint($discussion, $post),
            $notify->all()
        );
    }
}
