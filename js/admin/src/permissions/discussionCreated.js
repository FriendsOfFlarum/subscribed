export default function (items) {
    items.add('subscribeDiscussionCreated', {
        icon: 'bell',
        label: app.translator.trans('flagrow-subscribed.admin.permission.subscribe_to_discussion_created'),
        permission: 'subscribeDiscussionCreated'
    }, 95);
}
