import { extend } from "flarum/extend";
import PermissionGrid from "flarum/components/PermissionGrid";
import discussionCreated from "./permissions/discussionCreated";
import userCreated from "./permissions/userCreated";

export default function () {
    extend(PermissionGrid.prototype, 'startItems', items => {
        discussionCreated(items);
        userCreated(items);
    });
}
