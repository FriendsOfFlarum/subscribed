<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Jobs\Concerns;

use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait FindsSubscribedUsers
{
    /**
     * The users from $query who have switched on at least one channel
     * (`notify_{type}_alert`, `notify_{type}_email`, ...) for this type.
     *
     * The database does a coarse LIKE match, which every supported driver can
     * run. `_` is a LIKE wildcard, so it can only match too much, never too
     * little. The exact check runs on the decoded preferences in PHP, so it
     * doesn't depend on how a driver stores or formats JSON. (MySQL's JSON
     * column, for one, stores `"key": true` with a space.)
     *
     * @param Builder<User> $query
     * @return Collection<int, User>
     */
    protected function subscribedUsers(string $type, Builder $query): Collection
    {
        $key = '/^notify_'.preg_quote($type, '/').'_[a-z]+$/';

        return $query
            ->where('preferences', 'like', '%notify_'.$type.'_%')
            ->get()
            ->filter(function (User $user) use ($key) {
                $preferences = json_decode((string) $user->getRawOriginal('preferences'), true);

                foreach (is_array($preferences) ? $preferences : [] as $name => $enabled) {
                    if ($enabled === true && preg_match($key, (string) $name)) {
                        return true;
                    }
                }

                return false;
            })
            ->values();
    }
}
