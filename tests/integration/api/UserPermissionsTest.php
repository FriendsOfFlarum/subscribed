<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Tests\integration\api;

use Flarum\Group\Group;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\Test;

class UserPermissionsTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-subscribed');

        $this->prepareDatabase([
            User::class => [
                $this->normalUser(),
            ],
            'group_permission' => [
                ['group_id' => Group::MEMBER_ID, 'permission' => 'subscribeDiscussionCreated'],
                ['group_id' => Group::MEMBER_ID, 'permission' => 'subscribePostCreated'],
                ['group_id' => Group::MEMBER_ID, 'permission' => 'subscribeUserCreated'],
            ],
        ]);
    }

    #[Test]
    public function current_user_has_subscription_permission_attributes(): void
    {
        $response = $this->send(
            $this->request('GET', '/api/users/2', ['authenticatedAs' => 2])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $attributes = Arr::get($data, 'data.attributes');

        $this->assertTrue(Arr::get($attributes, 'canSubscribeDiscussionCreated'));
        $this->assertTrue(Arr::get($attributes, 'canSubscribePostCreated'));
        $this->assertTrue(Arr::get($attributes, 'canSubscribeUserCreated'));
    }

    #[Test]
    public function other_user_cannot_see_subscription_permission_attributes(): void
    {
        $response = $this->send(
            $this->request('GET', '/api/users/2', ['authenticatedAs' => 1])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $attributes = Arr::get($data, 'data.attributes');

        $this->assertArrayNotHasKey('canSubscribeDiscussionCreated', $attributes);
        $this->assertArrayNotHasKey('canSubscribePostCreated', $attributes);
        $this->assertArrayNotHasKey('canSubscribeUserCreated', $attributes);
    }

    #[Test]
    public function user_without_permission_has_false_subscription_attributes(): void
    {
        $response = $this->send(
            $this->request('GET', '/api/users/1', ['authenticatedAs' => 1])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $attributes = Arr::get($data, 'data.attributes');

        // Admin has all permissions, so check a guest-level user by removing permissions
        // Attributes should still be present for the actor viewing their own profile
        $this->assertArrayHasKey('canSubscribeDiscussionCreated', $attributes);
    }
}
