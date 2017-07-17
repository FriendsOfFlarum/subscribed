import Notification from 'flarum/components/Notification';

export default class UserCreatedNotification extends Notification {
    icon() {
        // Same as create discussion button on purpose.
        return 'user-plus';
    }

    href() {
        const notification = this.props.notification;

        return app.route.user(notification.subject());
    }

    content() {
        return app.translator.trans('flagrow-subscribed.forum.notifications.user_created_text', {user: this.props.notification.sender()});
    }
}
