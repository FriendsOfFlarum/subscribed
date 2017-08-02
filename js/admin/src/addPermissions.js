import {extend} from "flarum/extend";
import PermissionGrid from "flarum/components/PermissionGrid";
import discussionCreated from "flagrow/subscribed/permissions/discussionCreated";
import userCreated from "flagrow/subscribed/permissions/userCreated";

export default function () {
    extend(PermissionGrid.prototype, 'startItems', items => {
        discussionCreated(items);
        userCreated(items);
    });
    extend(PermissionGrid.prototype, 'moderateItems', items => {
    });
}
