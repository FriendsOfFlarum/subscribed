<?php

/*
 * This file is part of fof/subscribed.
 *
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Subscribed\Blueprints;

use Flarum\Notification\AlertableInterface;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;
use Flarum\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserCreatedBlueprint implements BlueprintInterface, MailableInterface, AlertableInterface
{
    public function __construct(public User $user)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSender(): User
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?\Flarum\Database\AbstractModel
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): mixed
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType(): string
    {
        return 'userCreated';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel(): string
    {
        return User::class;
    }

    /**
     * Get the name of the view to construct a notification email with.
     *
     * @return array
     */
    public function getEmailViews(): array
    {
        return ['text' => 'fof-subscribed::email.plain.userCreated', 'html' => 'fof-subscribed::email.html.userCreated'];
    }

    /**
     * Get the subject line for a notification email.
     *
     * @return string
     */
    public function getEmailSubject(\Flarum\Locale\TranslatorInterface $translator): string
    {
        return $translator->trans('fof-subscribed.email.subject.newUser', [
            '{username}' => $this->user->display_name,
        ]);
    }

    public function getFromUser(): ?\Flarum\User\User
    {
        return $this->user;
    }
}
