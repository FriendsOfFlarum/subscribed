<?php

namespace Flagrow\Subscribed\Listeners;

use Flagrow\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use Flarum\Api\Serializer\DiscussionBasicSerializer;
use Flarum\Core\Discussion;
use Flarum\Core\Notification\NotificationSyncer;
use Flarum\Core\User;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Event\DiscussionWasDeleted;
use Flarum\Event\DiscussionWasRestored;
use Flarum\Event\DiscussionWasStarted;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Query\Expression;

class DiscussionCreated
{

    /**
     * @var NotificationSyncer
     */
    protected $notifications;

    /**
     * @param NotificationSyncer $notifications
     */
    public function __construct(NotificationSyncer $notifications)
    {
        $this->notifications = $notifications;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureNotificationTypes::class, [$this, 'addType']);
        $events->listen(DiscussionWasStarted::class, [$this, 'whenDiscussionWasStarted']);
        $events->listen(DiscussionWasDeleted::class, [$this, 'whenDiscussionWasDeleted']);
        $events->listen(DiscussionWasRestored::class, [$this, 'whenDiscussionWasRestored']);
    }

    /**
     * @param ConfigureNotificationTypes $event
     */
    public function addType(ConfigureNotificationTypes $event)
    {
        $event->add(
            DiscussionCreatedBlueprint::class,
            DiscussionBasicSerializer::class,
            []
        );
    }

    /**
     * @param DiscussionWasStarted $event
     */
    public function whenDiscussionWasStarted(DiscussionWasStarted $event)
    {
        $discussion = $event->discussion;

        $notify = User::query()
            ->where('users.id', '!=', $discussion->start_user_id)
            ->where('preferences', 'regexp', new Expression('\'"notify_discussionCreated_[a-z]+":true\''))
            ->get();

        $notify = $notify->filter(function (User $recipient) use ($discussion) {
            return $recipient->can('subscribeDiscussionCreated') &&
                $recipient->can('viewDiscussions', $discussion);
        });

        $this->notifications->sync(
            $this->getNotification($event->discussion),
            $notify->all()
        );
    }

    /**
     * @param DiscussionWasDeleted $event
     */
    public function whenDiscussionWasDeleted(DiscussionWasDeleted $event)
    {
        $this->notifications->delete($this->getNotification($event->discussion));
    }

    /**
     * @param DiscussionWasRestored $event
     */
    public function whenDiscussionWasRestored(DiscussionWasRestored $event)
    {
        $this->notifications->restore($this->getNotification($event->discussion));
    }


    /**
     * @param Discussion $discussion
     * @return DiscussionCreatedBlueprint
     */
    protected function getNotification(Discussion $discussion)
    {
        return new DiscussionCreatedBlueprint($discussion);
    }
}
