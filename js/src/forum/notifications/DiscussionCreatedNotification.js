import Notification from 'flarum/components/Notification';

export default class DiscussionCreatedNotification extends Notification {
    icon() {
        // Same as create discussion button on purpose.
        return 'fas fa-edit';
    }

    href() {
        const notification = this.props.notification;

        return app.route.discussion(notification.subject());
    }

    content() {
        return app.translator.trans('fof-subscribed.forum.notifications.discussion_created_text', { user: this.props.notification.fromUser() });
    }
}
