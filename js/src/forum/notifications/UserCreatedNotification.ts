import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';
import type User from 'flarum/common/models/User';
import type Mithril from 'mithril';

export default class UserCreatedNotification extends Notification {
  icon(): string {
    return 'fas fa-user-plus';
  }

  href(): string {
    const notification = this.attrs.notification;

    return app.route.user(notification.subject() as User);
  }

  content(): Mithril.Children {
    return app.translator.trans('fof-subscribed.forum.notifications.user_created_text', { user: this.attrs.notification.fromUser() });
  }

  excerpt(): Mithril.Children {
    return null;
  }
}
