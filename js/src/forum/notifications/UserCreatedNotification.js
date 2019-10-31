import Notification from 'flarum/components/Notification';

export default class UserCreatedNotification extends Notification {
    icon() {
        return 'fas fa-user-plus';
    }

    href() {
        const notification = this.props.notification;

        return app.route.user(notification.subject());
    }

    content() {
        return app.translator.trans('fof-subscribed.forum.notifications.user_created_text', { user: this.props.notification.fromUser() });
    }
}
