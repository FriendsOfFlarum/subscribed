import {extend} from 'flarum/extend';
import addSubscriptionPane from 'flagrow/subscribed/addSubscriptionPane';

app.initializers.add('flagrow-subscribed', function(app) {
    addSubscriptionPane();
});
