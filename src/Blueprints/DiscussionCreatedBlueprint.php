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
use Flarum\Discussion\Discussion;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;
use Flarum\Post\Post;
use Flarum\User\User;
use Symfony\Contracts\Translation\TranslatorInterface;

class DiscussionCreatedBlueprint implements BlueprintInterface, MailableInterface, AlertableInterface
{
    /**
     * @var Post
     */
    public $post;

    public function __construct(public Discussion $discussion, ?Post $post = null)
    {
        $this->post = $post ?? $discussion->firstPost;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender(): ?User
    {
        return $this->discussion->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject(): ?\Flarum\Database\AbstractModel
    {
        return $this->discussion;
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
        return 'discussionCreated';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel(): string
    {
        return Discussion::class;
    }

    /**
     * Get the name of the view to construct a notification email with.
     *
     * @return array
     */
    public function getEmailViews(): array
    {
        return ['text' => 'fof-subscribed::emails.discussionCreated'];
    }

    /**
     * Get the subject line for a notification email.
     *
     * @return string
     */
    public function getEmailSubject(\Flarum\Locale\TranslatorInterface $translator): string
    {
        return $translator->trans('fof-subscribed.email.subject.newDiscussion', [
            '{title}' => $this->discussion->title,
        ]);
    }

    public function getFromUser(): ?\Flarum\User\User
    {
        return $this->discussion->user;
    }
}
