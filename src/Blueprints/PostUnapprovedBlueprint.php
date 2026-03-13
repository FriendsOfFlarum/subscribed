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
use Flarum\Post\Post;
use Flarum\Locale\TranslatorInterface;
use Flarum\User\User;

class PostUnapprovedBlueprint implements BlueprintInterface, MailableInterface, AlertableInterface
{
    public function __construct(public Post $post)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSender(): ?User
    {
        return $this->post->user;
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
        return 'postUnapproved';
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
        return ['text' => 'fof-subscribed::email.plain.postUnapproved', 'html' => 'fof-subscribed::email.html.postUnapproved'];
    }

    /**
     * Get the subject line for a notification email.
     *
     * @return string
     */
    public function getEmailSubject(TranslatorInterface $translator): string
    {
        return $translator->trans('fof-subscribed.email.subject.postUnapproved', [
            '{username}' => $this->post->user->display_name,
            '{title}'    => $this->post->discussion->title,
        ]);
    }

    public function getFromUser(): ?User
    {
        return $this->post->user;
    }
}
