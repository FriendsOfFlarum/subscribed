import { extend } from 'flarum/extend';
import PermissionGrid from 'flarum/components/PermissionGrid';

app.initializers.add('fof-subscribed', () => {
    extend(PermissionGrid.prototype, 'startItems', items => {
        items.add(
            'subscribeDiscussionCreated',
            {
                icon: 'fas fa-bell',
                label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_discussion_created'),
                permission: 'subscribeDiscussionCreated',
            },
            95
        );

        items.add(
            'subscribeUserCreated',
            {
                icon: 'fas fa-bell',
                label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_user_created'),
                permission: 'subscribeUserCreated',
            },
            95
        );
    });

    extend(PermissionGrid.prototype, 'moderateItems', items => {
        items.add('subscribePostUnapproved', {
            icon: 'fas fa-gavel',
            label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_post_unapproved'),
            permission: 'subscribePostUnapproved',
        });
    });
});
