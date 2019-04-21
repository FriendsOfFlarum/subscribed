import { extend } from 'flarum/extend';
import addPermissions from "./addPermissions";

app.initializers.add('flagrow-subscribed',() => {
    addPermissions();
});
