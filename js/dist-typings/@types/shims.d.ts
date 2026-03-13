import User from 'flarum/common/models/User';

declare module 'flarum/common/models/User' {
  export default interface User {
    canSubscribeDiscussionCreated(): boolean | undefined;
    canSubscribePostCreated(): boolean | undefined;
    canSubscribePostUnapproved(): boolean | undefined;
    canSubscribeUserCreated(): boolean | undefined;
    canSubscribePostFlagged(): boolean | undefined;
  }
}
