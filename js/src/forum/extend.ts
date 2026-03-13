import Extend from 'flarum/common/extenders';
import User from 'flarum/common/models/User';

export default [
    new Extend.Model(User) //
        .attribute('canSubscribeDiscussionCreated')
        .attribute('canSubscribePostCreated')
        .attribute('canSubscribePostUnapproved')
        .attribute('canSubscribeUserCreated')
        .attribute('canSubscribePostFlagged'),
];
