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

use Flarum\Discussion\Discussion;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Expression;
use Illuminate\Queue\SerializesModels;

class SendNotificationWhenDiscussionIsStarted implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Discussion
     */
    protected $discussion;

    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    public function handle(NotificationSyncer $notifications)
    {
        $discussion = $this->discussion;

        $notify = User::query()
            ->where('users.id', '!=', $discussion->user_id)
            ->where('preferences', 'regexp', new Expression('\'"notify_discussionCreated_[a-z]+":true\''))
            ->get();

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
