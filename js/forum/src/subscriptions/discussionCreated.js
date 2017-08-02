import DiscussionCreatedNotification from 'flagrow/subscribed/notifications/DiscussionCreatedNotification';

export default function (items, app) {
    if (app.forum.data.attributes.subscribeDiscussionCreated) {
        app.notificationComponents.discussionCreated = DiscussionCreatedNotification;

        items.add('discussionCreated', {
            name: 'discussionCreated',
            icon: 'pencil',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
        }, 5);
    }

    return items;
}
