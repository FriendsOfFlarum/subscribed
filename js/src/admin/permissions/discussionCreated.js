export default function (items) {
    items.add('subscribeDiscussionCreated', {
        icon: 'fas fa-bell',
        label: app.translator.trans('fof-subscribed.admin.permission.subscribe_to_discussion_created'),
        permission: 'subscribeDiscussionCreated'
    }, 95);
}
