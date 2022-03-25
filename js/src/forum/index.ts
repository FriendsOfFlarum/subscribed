import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import NotificationGrid from 'flarum/forum/components/NotificationGrid';

import DiscussionCreatedNotification from './notifications/DiscussionCreatedNotification';
import PostCreatedNotification from './notifications/PostCreatedNotification';
import UserCreatedNotification from './notifications/UserCreatedNotification';
import PostUnapprovedNotification from './notifications/PostUnapprovedNotification';
import User from 'flarum/common/models/User';
import Model from 'flarum/common/Model';
import ItemList from 'flarum/common/utils/ItemList';
import PostFlaggedNotification from './notifications/PostFlaggedNotification';

app.initializers.add('fof-subscribed', () => {
  app.notificationComponents.discussionCreated = DiscussionCreatedNotification;
  app.notificationComponents.postCreated = PostCreatedNotification;
  app.notificationComponents.userCreated = UserCreatedNotification;
  app.notificationComponents.postUnapproved = PostUnapprovedNotification;
  app.notificationComponents.postFlagged = PostFlaggedNotification;

  User.prototype.canSubscribeDiscussionCreated = Model.attribute('canSubscribeDiscussionCreated');
  User.prototype.canSubscribePostCreated = Model.attribute('canSubscribePostCreated');
  User.prototype.canSubscribePostUnapproved = Model.attribute('canSubscribePostUnapproved');
  User.prototype.canSubscribeUserCreated = Model.attribute('canSubscribeUserCreated');
  User.prototype.canSubscribePostFlagged = Model.attribute('canSubscribePostFlagged');

  extend(NotificationGrid.prototype, 'notificationTypes', (items: ItemList) => {
    const currentUser = app.session?.user;

    if (currentUser?.canSubscribeDiscussionCreated()) {
      items.add(
        'discussionCreated',
        {
          name: 'discussionCreated',
          icon: 'fas fa-pencil-alt',
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
          icon: 'fas fa-pencil-alt',
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
          icon: 'fas fa-check',
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
});
