import Notification from 'flarum/components/Notification';

export default class DiscussionCreatedNotification extends Notification {
    icon() {
        return 'pencil';
    }

    href() {
        const notification = this.props.notification;

        return app.route.discussion(notification.subject(), notification.content().postNumber);
    }

    content() {
        return app.translator.trans('flarum-subscribed.forum.notifications.discussion_created_text', {user: this.props.notification.sender()});
    }
}
