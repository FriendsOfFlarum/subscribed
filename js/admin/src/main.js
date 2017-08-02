import {extend} from 'flarum/extend';
import addPermissions from "flagrow/subscribed/addPermissions";

app.initializers.add('flagrow-subscribed', function(app) {
    addPermissions();
});
