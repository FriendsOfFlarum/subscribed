"use strict";

System.register("flagrow/subscribed/addPermissions", ["flarum/extend", "flarum/components/PermissionGrid", "flagrow/subscribed/permissions/discussionCreated", "flagrow/subscribed/permissions/userCreated"], function (_export, _context) {
    "use strict";

    var extend, PermissionGrid, discussionCreated, userCreated;

    _export("default", function () {
        extend(PermissionGrid.prototype, 'startItems', function (items) {
            discussionCreated(items);
            userCreated(items);
        });
        extend(PermissionGrid.prototype, 'moderateItems', function (items) {});
    });

    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flarumComponentsPermissionGrid) {
            PermissionGrid = _flarumComponentsPermissionGrid.default;
        }, function (_flagrowSubscribedPermissionsDiscussionCreated) {
            discussionCreated = _flagrowSubscribedPermissionsDiscussionCreated.default;
        }, function (_flagrowSubscribedPermissionsUserCreated) {
            userCreated = _flagrowSubscribedPermissionsUserCreated.default;
        }],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/subscribed/main', ['flarum/extend', 'flagrow/subscribed/addPermissions'], function (_export, _context) {
    "use strict";

    var extend, addPermissions;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flagrowSubscribedAddPermissions) {
            addPermissions = _flagrowSubscribedAddPermissions.default;
        }],
        execute: function () {

            app.initializers.add('flagrow-subscribed', function (app) {
                addPermissions();
            });
        }
    };
});;
'use strict';

System.register('flagrow/subscribed/permissions/discussionCreated', [], function (_export, _context) {
    "use strict";

    _export('default', function (items) {
        items.add('subscribeDiscussionCreated', {
            icon: 'bell',
            label: app.translator.trans('flagrow-subscribed.admin.permission.subscribe_to_discussion_created'),
            permission: 'subscribeDiscussionCreated'
        }, 95);
    });

    return {
        setters: [],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/subscribed/permissions/userCreated', [], function (_export, _context) {
    "use strict";

    _export('default', function (items) {
        items.add('subscribeUserCreated', {
            icon: 'bell',
            label: app.translator.trans('flagrow-subscribed.admin.permission.subscribe_to_user_created'),
            permission: 'subscribeUserCreated'
        }, 95);
    });

    return {
        setters: [],
        execute: function () {}
    };
});