import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';
import { truncate } from 'flarum/common/utils/string';

export default class PostCreatedNotification extends Notification {
  icon() {
    return 'fas fa-edit';
  }

  href() {
    const notification = this.attrs.notification;
    const post = notification.subject();

    return app.route.discussion(post.discussion(), post.postNumber);
  }

  content() {
    return app.translator.trans('fof-subscribed.forum.notifications.post_created_text', { user: this.attrs.notification.fromUser() });
  }

  excerpt() {
    return truncate(this.attrs.notification.subject().contentPlain(), 200);
  }
}
