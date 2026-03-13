import app from 'flarum/forum/app';
import Notification from 'flarum/forum/components/Notification';
import { truncate } from 'flarum/common/utils/string';
import type Post from 'flarum/common/models/Post';
import type Mithril from 'mithril';

export default class PostUnapprovedNotification extends Notification {
  icon(): string {
    return 'fas fa-hammer';
  }

  href(): string {
    const notification = this.attrs.notification;
    const post = notification.subject() as Post;

    return app.route.discussion(post.discussion(), post.number());
  }

  content(): Mithril.Children {
    return app.translator.trans('fof-subscribed.forum.notifications.post_unapproved_text', { user: this.attrs.notification.fromUser() });
  }

  excerpt(): Mithril.Children {
    return truncate((this.attrs.notification.subject() as Post).contentPlain() ?? '', 200);
  }
}
