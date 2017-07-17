import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import discussionCreated from 'flagrow/subscribed/discussionCreated';
import userCreated from 'flagrow/subscribed/userCreated';
import extendsNotificationGrid from 'flagrow/subscribed/extendsNotificationGrid';

app.initializers.add('flagrow-subscribed', function(app) {
    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {

        items = discussionCreated(items, app);
        items = userCreated(items, app);

        return items;
    });

    extendsNotificationGrid(app);
});
