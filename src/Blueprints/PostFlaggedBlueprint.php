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
use Flarum\Flags\Flag;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;
use Flarum\Post\Post;
use Flarum\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class PostFlaggedBlueprint implements BlueprintInterface, MailableInterface, AlertableInterface
{
    public function __construct(public Post $post, public Flag $flag)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSender(): ?User
    {
        return $this->flag->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?\Flarum\Database\AbstractModel
    {
        return $this->post;
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
        return 'postFlagged';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel(): string
    {
        return Post::class;
    }

    /**
     * Get the name of the view to construct a notification email with.
     *
     * @return array
     */
    public function getEmailViews(): array
    {
        return ['text' => 'fof-subscribed::email.plain.postFlagged', 'html' => 'fof-subscribed::email.html.postFlagged'];
    }

    /**
     * Get the subject line for a notification email.
     *
     * @return string
     */
    public function getEmailSubject(\Flarum\Locale\TranslatorInterface $translator): string
    {
        return $translator->trans('fof-subscribed.email.subject.postFlagged', [
            '{username}' => $this->flag->user->display_name,
            '{title}'    => $this->post->discussion->title,
        ]);
    }

    public function getFromUser(): ?\Flarum\User\User
    {
        return $this->flag->user;
    }
}
