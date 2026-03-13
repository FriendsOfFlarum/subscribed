import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';
import type Discussion from 'flarum/common/models/Discussion';
import type Mithril from 'mithril';

export default class DiscussionCreatedNotification extends Notification {
  icon(): string {
    // Same as create discussion button on purpose.
    return 'fas fa-edit';
  }

  href(): string {
    const notification = this.attrs.notification;

    return app.route.discussion(notification.subject() as Discussion);
  }

  content(): Mithril.Children {
    return app.translator.trans('fof-subscribed.forum.notifications.discussion_created_text', { user: this.attrs.notification.fromUser() });
  }

  excerpt(): Mithril.Children {
    return null;
  }
}
