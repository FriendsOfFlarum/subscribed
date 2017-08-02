import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import discussionCreated from 'flagrow/subscribed/subscriptions/discussionCreated';
import userCreated from 'flagrow/subscribed/subscriptions/userCreated';

app.initializers.add('flagrow-subscribed', function(app) {
    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {

        items = discussionCreated(items, app);
        items = userCreated(items, app);

        return items;
    });
});
