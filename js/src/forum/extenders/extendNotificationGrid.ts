import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import ItemList from 'flarum/common/utils/ItemList';

export default function extendNotificationGrid() {
  extend('flarum/forum/components/NotificationGrid', 'notificationTypes', (items: ItemList<{ name: string; icon: string; label: any }>) => {
    const currentUser = app.session?.user;

    if (currentUser?.canSubscribeDiscussionCreated()) {
      items.add(
        'discussionCreated',
        {
          name: 'discussionCreated',
          icon: 'fas fa-pencil',
          label: app.translator.trans('fof-subscribed.forum.settings.notify_discussion_created_label'),
        },
        5
      );
    }

    if (currentUser?.canSubscribePostCreated()) {
      items.add(
        'postCreated',
        {
          name: 'postCreated',
          icon: 'fas fa-pencil',
          label: app.translator.trans('fof-subscribed.forum.settings.notify_post_created_label'),
        },
        4
      );
    }

    if (currentUser?.canSubscribePostUnapproved()) {
      items.add(
        'postUnapproved',
        {
          name: 'postUnapproved',
          icon: 'fas fa-hammer',
          label: app.translator.trans('fof-subscribed.forum.settings.notify_post_unapproved_label'),
        },
        -10
      );
    }

    if (currentUser?.canSubscribeUserCreated()) {
      items.add(
        'userCreated',
        {
          name: 'userCreated',
          icon: 'fas fa-user-plus',
          label: app.translator.trans('fof-subscribed.forum.settings.notify_user_created_label'),
        },
        -10
      );
    }

    if (currentUser?.canSubscribePostFlagged()) {
      items.add(
        'postFlagged',
        {
          name: 'postFlagged',
          icon: 'fas fa-flag',
          label: app.translator.trans('fof-subscribed.forum.settings.notify_post_flagged_label'),
        },
        -10
      );
    }
  });
}
