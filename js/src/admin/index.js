import { extend } from 'flarum/extend';
import addPermissions from "./addPermissions";

app.initializers.add('fof-subscribed',() => {
    addPermissions();
});
