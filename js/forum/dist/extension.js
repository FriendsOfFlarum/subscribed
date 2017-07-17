'use strict';

System.register('flagrow/subscribed/discussionCreated', [], function (_export, _context) {
    "use strict";

    _export('default', function (items) {

        items.add('discussionCreated', {
            name: 'discussionCreated',
            icon: 'pencil',
            label: app.translator.trans('flagrow-subscribed.forum.settings.notify_discussion_created_label')
        }, 5);

        return items;
    });

    return {
        setters: [],
        execute: function () {}
    };
});;
'use strict';

System.register('flagrow/subscribed/main', ['flarum/extend', 'flarum/components/NotificationGrid', 'flagrow/subscribed/discussionCreated', 'flagrow/subscribed/notification/DiscussionCreatedNotification'], function (_export, _context) {
    "use strict";

    var extend, NotificationGrid, discussionCreated, DiscussionCreatedNotification;
    return {
        setters: [function (_flarumExtend) {
            extend = _flarumExtend.extend;
        }, function (_flarumComponentsNotificationGrid) {
            NotificationGrid = _flarumComponentsNotificationGrid.default;
        }, function (_flagrowSubscribedDiscussionCreated) {
            discussionCreated = _flagrowSubscribedDiscussionCreated.default;
        }, function (_flagrowSubscribedNotificationDiscussionCreatedNotification) {
            DiscussionCreatedNotification = _flagrowSubscribedNotificationDiscussionCreatedNotification.default;
        }],
        execute: function () {

            app.initializers.add('flagrow-subscribed', function (app) {
                app.notificationComponents.discussionCreated = DiscussionCreatedNotification;

                extend(NotificationGrid.prototype, 'notificationTypes', function (items) {

                    items = discussionCreated(items);

                    return items;
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
});