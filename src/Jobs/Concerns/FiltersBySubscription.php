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

use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

trait FiltersBySubscription
{
    /**
     * Limit the query to users who have enabled at least one notification
     * driver (alert, email, or any driver added by another extension) for the
     * given notification type.
     *
     * This uses JSON path queries instead of a regex on the raw column:
     * `users.preferences` is a JSON column in Flarum 2.0, which MySQL hands
     * back normalised as `"key": true` (with a space), and PostgreSQL has no
     * REGEXP operator at all.
     */
    protected function whereSubscribedTo(Builder $query, string $type): void
    {
        $drivers = array_keys(NotificationSyncer::getNotificationDrivers());

        if (empty($drivers)) {
            $query->whereRaw('1 = 0');

            return;
        }

        $query->where(function (Builder $query) use ($type, $drivers) {
            foreach ($drivers as $driver) {
                $query->orWhere('preferences->'.User::getNotificationPreferenceKey($type, $driver), true);
            }
        });
    }
}
