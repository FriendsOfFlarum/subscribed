import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';

export default class PostCreatedNotification extends Notification {
  icon() {
    return 'fas fa-edit';
  }

  href() {
    const notification = this.attrs.notification;
    const discussion = notification.subject();
    const content = notification.content() || {};

    return app.route.discussion(discussion, content.postNumber);
  }

  content() {
    return app.translator.trans('fof-subscribed.forum.notifications.post_created_text', { user: this.attrs.notification.fromUser() });
  }
}
