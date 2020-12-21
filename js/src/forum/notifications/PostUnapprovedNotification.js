import Notification from 'flarum/components/Notification';
import { truncate } from 'flarum/utils/string';

export default class PostUnapprovedNotification extends Notification {
    icon() {
        return 'fas fa-gavel';
    }

    href() {
        const notification = this.attrs.notification;
        const post = notification.subject();

        return app.route.discussion(post.discussion(), post.number());
    }

    content() {
        return app.translator.trans('fof-subscribed.forum.notifications.post_unapproved_text', { user: this.attrs.notification.fromUser() });
    }

    excerpt() {
        return truncate(this.attrs.notification.subject().contentPlain(), 200);
    }
}
