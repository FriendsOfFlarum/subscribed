import {extend} from 'flarum/extend';
import NotificationGrid from 'flarum/components/NotificationGrid';
import discussionCreated from 'flagrow/subscribed/discussionCreated';

app.initializers.add('flagrow-subscribed', function(app) {
    extend(NotificationGrid.prototype, 'notificationTypes', function(items) {

        items = discussionCreated(items);

        return items;
    });
});
