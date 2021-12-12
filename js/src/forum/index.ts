import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import NotificationGrid from 'flarum/forum/components/NotificationGrid';

import DiscussionCreatedNotification from './notifications/DiscussionCreatedNotification';
import UserCreatedNotification from './notifications/UserCreatedNotification';
import PostUnapprovedNotification from './notifications/PostUnapprovedNotification';
import User from 'flarum/common/models/User';
import Model from 'flarum/common/Model';
import ItemList from 'flarum/common/utils/ItemList';

app.initializers.add('fof-subscribed', () => {
  app.notificationComponents.discussionCreated = DiscussionCreatedNotification;
  app.notificationComponents.userCreated = UserCreatedNotification;
  app.notificationComponents.postUnapproved = PostUnapprovedNotification;

  User.prototype.canSubscribeDiscussionCreated = Model.attribute('canSubscribeDiscussionCreated');
  User.prototype.canSubscribePostUnapproved = Model.attribute('canSubscribePostUnapproved');
  User.prototype.canSubscribeUserCreated = Model.attribute('canSubscribeUserCreated');

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
  });
});
