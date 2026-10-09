<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Tests\integration\jobs;

use Carbon\Carbon;
use Flarum\Discussion\Discussion;
use Flarum\Group\Group;
use Flarum\Post\Post;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use PHPUnit\Framework\Attributes\Test;

/**
 * The jobs pick their recipients from users.preferences. These run on every
 * database driver in CI: the lookup used to be a MySQL REGEXP, which Postgres
 * and SQLite can't run, so every reply and new discussion failed there.
 */
class NotifiesSubscribedUsersTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-subscribed');

        $this->prepareDatabase([
            User::class => [
                $this->normalUser(),
                ['id' => 3, 'username' => 'subscriber', 'email' => 'subscriber@machine.local', 'is_email_confirmed' => 1,
                    'preferences' => json_encode(['notify_postCreated_alert' => true, 'notify_discussionCreated_alert' => true])],
                ['id' => 4, 'username' => 'optedout', 'email' => 'optedout@machine.local', 'is_email_confirmed' => 1,
                    'preferences' => json_encode(['notify_postCreated_alert' => false, 'notify_discussionCreated_alert' => false])],
                ['id' => 5, 'username' => 'othertype', 'email' => 'othertype@machine.local', 'is_email_confirmed' => 1,
                    'preferences' => json_encode(['notify_userCreated_email' => true])],
            ],
            Discussion::class => [
                ['id' => 1, 'title' => 'A discussion', 'created_at' => Carbon::now()->subDay(), 'user_id' => 2, 'first_post_id' => 1, 'comment_count' => 1, 'last_post_number' => 1],
            ],
            Post::class => [
                ['id' => 1, 'discussion_id' => 1, 'created_at' => Carbon::now()->subDay(), 'user_id' => 2, 'type' => 'comment', 'content' => '<t><p>First</p></t>', 'number' => 1],
            ],
            'group_permission' => [
                ['group_id' => Group::MEMBER_ID, 'permission' => 'subscribeDiscussionCreated'],
                ['group_id' => Group::MEMBER_ID, 'permission' => 'subscribePostCreated'],
            ],
        ]);
    }

    #[Test]
    public function a_reply_notifies_only_users_subscribed_to_new_posts(): void
    {
        $response = $this->send(
            $this->request('POST', '/api/posts', [
                'authenticatedAs' => 2,
                'json' => [
                    'data' => [
                        'type' => 'posts',
                        'attributes' => ['content' => 'A reply'],
                        'relationships' => ['discussion' => ['data' => ['type' => 'discussions', 'id' => '1']]],
                    ],
                ],
            ])
        );

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());
        $this->assertEquals([3], $this->recipientsOf('postCreated'));
    }

    #[Test]
    public function a_new_discussion_notifies_only_users_subscribed_to_new_discussions(): void
    {
        $response = $this->send(
            $this->request('POST', '/api/discussions', [
                'authenticatedAs' => 2,
                'json' => [
                    'data' => [
                        'type' => 'discussions',
                        'attributes' => ['title' => 'Another discussion', 'content' => 'Its first post'],
                    ],
                ],
            ])
        );

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());
        $this->assertEquals([3], $this->recipientsOf('discussionCreated'));
    }

    private function recipientsOf(string $type): array
    {
        return $this->database()->table('notifications')
            ->where('type', $type)
            ->orderBy('user_id')
            ->pluck('user_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }
}
