'use strict';

System.register('flagrow/subscribed/discussionCreated', ['flagrow/subscribed/notification/DiscussionCreatedNotification'], function (_export, _context) {
    "use strict";

    var DiscussionCreatedNotification;

    _export('default', function (items, app) {
        app.notificationComponents.discussionCreated = DiscussionCreatedNotification;

        items.add('discussionCreated', {
            name: 'discussionCreated',
            icon: 'pencil',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
        }, 5);

        return items;
    });

    return {
        setters: [function (_flagrowSubscribedNotificationDiscussionCreatedNotification) {
            DiscussionCreatedNotification = _flagrowSubscribedNotificationDiscussionCreatedNotification.default;
        }],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/subscribed/main', ['flarum/extend', 'flarum/components/NotificationGrid', 'flagrow/subscribed/discussionCreated', 'flagrow/subscribed/userCreated', 'flarum/components/Checkbox'], function (_export, _context) {
    "use strict";

    var extend, NotificationGrid, discussionCreated, userCreated, Checkbox;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flarumComponentsNotificationGrid) {
            NotificationGrid = _flarumComponentsNotificationGrid.default;
        }, function (_flagrowSubscribedDiscussionCreated) {
            discussionCreated = _flagrowSubscribedDiscussionCreated.default;
        }, function (_flagrowSubscribedUserCreated) {
            userCreated = _flagrowSubscribedUserCreated.default;
        }, function (_flarumComponentsCheckbox) {
            Checkbox = _flarumComponentsCheckbox.default;
        }],
        execute: function () {

            app.initializers.add('flagrow-subscribed', function (app) {
                extend(NotificationGrid.prototype, 'notificationTypes', function (items) {

                    items = discussionCreated(items, app);
                    items = userCreated(items, app);

                    return items;
                });

                extend(NotificationGrid.prototype, 'init', function () {
                    var _this = this;

                    var adds = [];

                    this.methods.forEach(function (type) {
                        adds.push({
                            parent: type.name,
                            name: type.name + '_defaults',
                            icon: type.icon,
                            label: app.translator.trans('flagrow-subscribed.forum.settings.defaults_label', { setting: type.label })
                        });
                        adds.push({
                            parent: type.name,
                            name: type.name + '_forced',
                            icon: type.icon,
                            label: app.translator.trans('flagrow-subscribed.forum.settings.forced_label', { setting: type.label })
                        });
                    });

                    this.types.forEach(function (type) {
                        adds.forEach(function (method) {
                            var parent = _this.preferenceKey(type.name, method.parent);
                            var key = _this.preferenceKey(type.name, method.name);
                            var preference = _this.props.user.preferences()[key];
                            var parentPreference = _this.props.user.preferences()[parent];

                            _this.inputs[key] = new Checkbox({
                                state: !!preference,
                                disabled: typeof parentPreference === 'undefined',
                                onchange: function onchange() {
                                    return _this.toggle([key]);
                                }
                            });
                        });
                    });

                    this.methods = this.methods.concat(adds);

                    this.methods.sort(function (a, b) {
                        if (a.name < b.name) {
                            return -1;
                        }
                        if (a.name > b.name) {
                            return 1;
                        }

                        return 0;
                    });
                });
            });
        }
    };
});;
'use strict';

System.register('flagrow/subscribed/notification/DiscussionCreatedNotification', ['flarum/components/Notification'], function (_export, _context) {
    "use strict";

    var Notification, DiscussionCreatedNotification;
    return {
        setters: [function (_flarumComponentsNotification) {
            Notification = _flarumComponentsNotification.default;
        }],
        execute: function () {
            DiscussionCreatedNotification = function (_Notification) {
                babelHelpers.inherits(DiscussionCreatedNotification, _Notification);

                function DiscussionCreatedNotification() {
                    babelHelpers.classCallCheck(this, DiscussionCreatedNotification);
                    return babelHelpers.possibleConstructorReturn(this, (DiscussionCreatedNotification.__proto__ || Object.getPrototypeOf(DiscussionCreatedNotification)).apply(this, arguments));
                }

                babelHelpers.createClass(DiscussionCreatedNotification, [{
                    key: 'icon',
                    value: function icon() {
                        // Same as create discussion button on purpose.
                        return 'edit';
                    }
                }, {
                    key: 'href',
                    value: function href() {
                        var notification = this.props.notification;

                        return app.route.discussion(notification.subject());
                    }
                }, {
                    key: 'content',
                    value: function content() {
                        return app.translator.trans('flagrow-subscribed.forum.notifications.discussion_created_text', { user: this.props.notification.sender() });
                    }
                }]);
                return DiscussionCreatedNotification;
            }(Notification);

            _export('default', DiscussionCreatedNotification);
        }
    };
});;
'use strict';

System.register('flagrow/subscribed/notification/UserCreatedNotification', ['flarum/components/Notification'], function (_export, _context) {
    "use strict";

    var Notification, UserCreatedNotification;
    return {
        setters: [function (_flarumComponentsNotification) {
            Notification = _flarumComponentsNotification.default;
        }],
        execute: function () {
            UserCreatedNotification = function (_Notification) {
                babelHelpers.inherits(UserCreatedNotification, _Notification);

                function UserCreatedNotification() {
                    babelHelpers.classCallCheck(this, UserCreatedNotification);
                    return babelHelpers.possibleConstructorReturn(this, (UserCreatedNotification.__proto__ || Object.getPrototypeOf(UserCreatedNotification)).apply(this, arguments));
                }

                babelHelpers.createClass(UserCreatedNotification, [{
                    key: 'icon',
                    value: function icon() {
                        // Same as create discussion button on purpose.
                        return 'user-plus';
                    }
                }, {
                    key: 'href',
                    value: function href() {
                        var notification = this.props.notification;

                        return app.route.user(notification.subject());
                    }
                }, {
                    key: 'content',
                    value: function content() {
                        return app.translator.trans('flagrow-subscribed.forum.notifications.user_created_text', { user: this.props.notification.sender() });
                    }
                }]);
                return UserCreatedNotification;
            }(Notification);

            _export('default', UserCreatedNotification);
        }
    };
});;
'use strict';

System.register('flagrow/subscribed/userCreated', ['flagrow/subscribed/notification/UserCreatedNotification'], function (_export, _context) {
    "use strict";

    var UserCreatedNotification;

    _export('default', function (items, app) {
        app.notificationComponents.userCreated = UserCreatedNotification;

        items.add('userCreated', {
            name: 'userCreated',
            icon: 'user-plus',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_user_created_label')
        }, -10);

        return items;
    });

    return {
        setters: [function (_flagrowSubscribedNotificationUserCreatedNotification) {
            UserCreatedNotification = _flagrowSubscribedNotificationUserCreatedNotification.default;
        }],
        execute: function () {}
    };
});