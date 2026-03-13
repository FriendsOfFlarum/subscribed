<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Tests\unit\Blueprints;

use Flarum\User\User;
use FoF\Subscribed\Blueprints\UserCreatedBlueprint;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserCreatedBlueprintTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
        $this->user->username = 'carol';
    }

    #[Test]
    public function returns_correct_type(): void
    {
        $this->assertEquals('userCreated', UserCreatedBlueprint::getType());
    }

    #[Test]
    public function returns_correct_subject_model(): void
    {
        $this->assertEquals(User::class, UserCreatedBlueprint::getSubjectModel());
    }

    #[Test]
    public function returns_user_as_subject(): void
    {
        $blueprint = new UserCreatedBlueprint($this->user);

        $this->assertSame($this->user, $blueprint->getSubject());
    }

    #[Test]
    public function returns_user_as_sender(): void
    {
        $blueprint = new UserCreatedBlueprint($this->user);

        $this->assertSame($this->user, $blueprint->getSender());
    }

    #[Test]
    public function returns_correct_email_views(): void
    {
        $blueprint = new UserCreatedBlueprint($this->user);
        $views = $blueprint->getEmailViews();

        $this->assertEquals('fof-subscribed::email.plain.userCreated', $views['text']);
        $this->assertEquals('fof-subscribed::email.html.userCreated', $views['html']);
    }

    #[Test]
    public function returns_empty_array_for_data(): void
    {
        $blueprint = new UserCreatedBlueprint($this->user);

        $this->assertEquals([], $blueprint->getData());
    }
}
