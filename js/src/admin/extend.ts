import Extend from 'flarum/common/extenders';
import app from 'flarum/admin/app';

export default [
  new Extend.Admin()
    .permission(
      () => ({
        icon: 'fas fa-bell',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_discussion_created'),
        permission: 'subscribeDiscussionCreated',
      }),
      'start'
    )
    .permission(
      () => ({
        icon: 'fas fa-bell',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_post_created'),
        permission: 'subscribePostCreated',
      }),
      'start'
    )
    .permission(
      () => ({
        icon: 'fas fa-bell',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_user_created'),
        permission: 'subscribeUserCreated',
      }),
      'start'
    )
    .permission(
      () => ({
        icon: 'fas fa-hammer',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_post_unapproved'),
        permission: 'subscribePostUnapproved',
      }),
      'moderate'
    )
    .permission(
      () => ({
        icon: 'fas fa-flag',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_post_flagged'),
        permission: 'subscribePostFlagged',
      }),
      'moderate'
    ),
];
