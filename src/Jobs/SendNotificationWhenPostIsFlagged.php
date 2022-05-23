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
use Illuminate\Database\Query\Expression;

class SendNotificationWhenPostIsFlagged extends AbstractJob
{
    /**
     * @var Flag
     */
    protected $flag;

    public function __construct(Flag $flag)
    {
        $this->flag = $flag;
    }
    
    public function handle(NotificationSyncer $notifications)
    {
        $post = $this->flag->post;
        $flag = $this->flag;

        $notify = User::query()
            ->where('users.id', '!=', $flag->user_id)
            ->where('preferences', 'regexp', new Expression('\'"notify_postFlagged_[a-z]+":true\''))
            ->get();

        $notify = $notify->filter(function (User $recipient) use ($post) {
            return $recipient->can('subscribePostFlagged') && $recipient->can('viewFlags', $post->discussion);
        });

        $notifications->sync(
            new PostFlaggedBlueprint($post, $flag),
            $notify->all()
        );
    }
}
