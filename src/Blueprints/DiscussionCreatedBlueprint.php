<?php

namespace Flagrow\Subscribed\Blueprints;

use Flarum\Discussion\Discussion;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\MailableInterface;

class DiscussionCreatedBlueprint implements BlueprintInterface, MailableInterface
{
    /**
     * @var Discussion
     */
    public $discussion;

    /**
     * @param Discussion $discussion
     */
    public function __construct(Discussion $discussion)
    {
        $this->discussion = $discussion;
    }

    /**
     * {@inheritdoc}
     */
    public function getSender()
    {
        return $this->discussion->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubject()
    {
        return $this->discussion;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
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
     * @return array
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
        return $this->discussion->title;
    }

    public function getFromUser()
    {
        return $this->discussion->user;
    }
}
