import app from 'flarum/app';

app.initializers.add('fof-subscribed', () => {
    app.extensionData.for('fof-subscribed')
        .registerPermission({
            icon: 'fas fa-bell',
            label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_discussion_created'),
            permission: 'subscribeDiscussionCreated',
        }, 'start')
        .registerPermission({
            icon: 'fas fa-bell',
            label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_user_created'),
            permission: 'subscribeUserCreated',
        }, 'start')
        .registerPermission({
            icon: 'fas fa-gavel',
            label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_post_unapproved'),
            permission: 'subscribePostUnapproved',
        }, 'moderate');
});
