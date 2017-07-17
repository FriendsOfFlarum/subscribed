import DiscussionCreatedNotification from 'flagrow/subscribed/notifications/DiscussionCreatedNotification';

export default function (items, app) {
    app.notificationComponents.discussionCreated = DiscussionCreatedNotification;

    items.add('discussionCreated', {
        name: 'discussionCreated',
        icon: 'pencil',
        label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
    }, 5);

    return items;
}
