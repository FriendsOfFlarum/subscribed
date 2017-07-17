import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import discussionCreated from 'flagrow/subscribed/discussionCreated';
import DiscussionCreatedNotification from 'flagrow/subscribed/notification/DiscussionCreatedNotification';

app.initializers.add('flagrow-subscribed', function(app) {
    app.notificationComponents.discussionCreated = DiscussionCreatedNotification;

    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {

        items = discussionCreated(items);

        return items;
    });
});
