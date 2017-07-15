<?php

namespace Flagrow\Subscribed\Blueprints;

use Flarum\Core\Discussion;
use Flarum\Core\Notification\BlueprintInterface;
use Flarum\Core\Notification\MailableInterface;
use Flarum\Lock\Post\DiscussionLockedPost;

class DiscussionCreatedBlueprint implements BlueprintInterface, MailableInterface
{
    /**
     * @var DiscussionLockedPost
     */
    protected $post;

    /**
     * @param DiscussionLockedPost $post
     */
    public function __construct(DiscussionLockedPost $post)
    {
        $this->post = $post;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->post->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->post->discussion;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return ['postNumber' => (int) $this->post->number];
    }

    /**
     * {@inheritdoc}
     */
    public static function getType()
    {
        return 'discussionCreated';
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubjectModel()
    {
        return Discussion::class;
    }

    /**
     * Get the name of the view to construct a notification email with.
     *
     * @return string
     */
    public function getEmailView()
    {
        return ['text' => 'flagrow-subscribed::emails.discussionCreated'];
    }

    /**
     * Get the subject line for a notification email.
     *
     * @return string
     */
    public function getEmailSubject()
    {
        return $this->post->discussion;
    }
}
