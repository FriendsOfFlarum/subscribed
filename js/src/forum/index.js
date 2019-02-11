import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';

import DiscussionCreatedNotification from './notifications/DiscussionCreatedNotification';
import UserCreatedNotification from './notifications/UserCreatedNotification';

app.initializers.add('flagrow-subscribed', (app) => {
    app.notificationComponents.discussionCreated = DiscussionCreatedNotification;
    app.notificationComponents.userCreated = UserCreatedNotification;

    extend(NotificationGrid.prototype, 'notificationTypes', (items) => {
        items.add('discussionCreated', {
            name: 'discussionCreated',
            icon: 'fas fa-pencil-alt',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
        }, 5);
        items.add('userCreated', {
            name: 'userCreated',
            icon: 'fas fa-user-plus',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_user_created_label')
        }, -10);
    });
});
