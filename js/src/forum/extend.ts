import Extend from 'flarum/common/extenders';
import User from 'flarum/common/models/User';

import DiscussionCreatedNotification from './notifications/DiscussionCreatedNotification';
import PostCreatedNotification from './notifications/PostCreatedNotification';
import PostFlaggedNotification from './notifications/PostFlaggedNotification';
import PostUnapprovedNotification from './notifications/PostUnapprovedNotification';
import UserCreatedNotification from './notifications/UserCreatedNotification';

export default [
  new Extend.Model(User)
    .attribute('canSubscribeDiscussionCreated')
    .attribute('canSubscribePostCreated')
    .attribute('canSubscribePostUnapproved')
    .attribute('canSubscribeUserCreated')
    .attribute('canSubscribePostFlagged'),

  new Extend.Notification()
    .add('discussionCreated', DiscussionCreatedNotification)
    .add('postCreated', PostCreatedNotification)
    .add('postUnapproved', PostUnapprovedNotification)
    .add('userCreated', UserCreatedNotification)
    .add('postFlagged', PostFlaggedNotification),
];
