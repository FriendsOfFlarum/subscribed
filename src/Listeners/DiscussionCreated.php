<?php

namespace FoF\Subscribed\Listeners;

use FoF\Subscribed\Blueprints\DiscussionCreatedBlueprint;
use Flarum\Api\Serializer\BasicDiscussionSerializer;
use Flarum\Discussion\Discussion;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;
use Flarum\Event\ConfigureNotificationTypes;
use Flarum\Discussion\Event\Deleted;
use Flarum\Discussion\Event\Restored;
use Flarum\Discussion\Event\Started;
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
        $events->listen(Started::class, [$this, 'whenDiscussionWasStarted']);
        $events->listen(Deleted::class, [$this, 'whenDiscussionWasDeleted']);
        $events->listen(Restored::class, [$this, 'whenDiscussionWasRestored']);
    }

    /**
     * @param ConfigureNotificationTypes $event
     */
    public function addType(ConfigureNotificationTypes $event)
    {
        $event->add(
            DiscussionCreatedBlueprint::class,
            BasicDiscussionSerializer::class,
            []
        );
    }

    /**
     * @param Started $event
     */
    public function whenDiscussionWasStarted(Started $event)
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
     * @param Deleted $event
     */
    public function whenDiscussionWasDeleted(Deleted $event)
    {
        $this->notifications->delete($this->getNotification($event->discussion));
    }

    /**
     * @param Restored $event
     */
    public function whenDiscussionWasRestored(Restored $event)
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
